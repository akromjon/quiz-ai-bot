<?php

declare(strict_types=1);

namespace App\Service;

use App\AI\Model\Model;
use App\AI\Lib\QuizGenerator;
use App\Enum\Status;
use App\Events\QuizProgressUpdated;
use App\Models\Question;
use App\Models\QuizRequest;
use App\Models\Quiz as QuizModel;
use App\Exceptions\QuizGenerationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class QuizService
{
    private const EXPECTED_QUIZ_KEY = 'quizzes';

    public function __construct(
        protected QuizRequest $quizRequest,
        protected ?QuizGenerator $quizGenerator = null
    ) {
        $this->quizGenerator = $quizGenerator ?? QuizGenerator::make();
    }

    public function handle(): void
    {
        try {
            DB::transaction(function () {
                $this->validateInitialState();
                $this->processQuizGeneration();
            });
        } catch (QuizGenerationException $e) {
            $this->handleError($e, 'Quiz Generation Format Error');
        } catch (\Exception $e) {
            $this->handleError($e, 'Quiz Generation Failed');
        }
    }

    private function validateInitialState(): void
    {
        $this->checkQuizState($this->quizRequest);
        $this->updateQuizRequestStatus(Status::PROCESSING);
    }

    private function processQuizGeneration(): void
    {
        $targetQuestionCount = $this->quizRequest->number_of_question->value;
        $totalGenerated = 0;

        // First attempt to generate all requested questions
        $quizData = $this->generateAndValidateQuiz($targetQuestionCount);

        $generatedCount = count($quizData[self::EXPECTED_QUIZ_KEY]);

        if ($generatedCount > 0) {
            $quizModel = $this->createQuizModel($quizData[self::EXPECTED_QUIZ_KEY]);
            $this->createQuestions($quizModel, $quizData[self::EXPECTED_QUIZ_KEY]);
            $totalGenerated = $generatedCount;
        }

        // If we didn't generate all requested questions, try to generate the remaining ones
        if ($totalGenerated < $targetQuestionCount) {
            $remainingQuestions = $targetQuestionCount - $totalGenerated;

            // Generate only the remaining questions needed
            $additionalQuizData = $this->generateAndValidateQuiz($remainingQuestions);
            $additionalCount = count($additionalQuizData[self::EXPECTED_QUIZ_KEY]);

            if ($additionalCount > 0) {
                $quizModel = $this->createQuizModel($additionalQuizData[self::EXPECTED_QUIZ_KEY]);
                $this->createQuestions($quizModel, $additionalQuizData[self::EXPECTED_QUIZ_KEY]);
                $totalGenerated += $additionalCount;
            }
        }

        if ($totalGenerated === 0 && $totalGenerated < $targetQuestionCount) {
            throw new QuizGenerationException('Failed to generate any valid questions');
        }

        $this->updateQuizRequestStatus(
            Status::COMPLETED,
            [],
            $totalGenerated
        );
    }

    private function generateAndValidateQuiz(int $numberOfQuestions): array
    {
        $quiz = $this->quizGenerator->generate(
            model: Model::GPT_3_5_TURBO,
            text: $this->quizRequest->text,
            numberOfQuizes: $numberOfQuestions,
            language: $this->quizRequest->language,
            difficulty: $this->quizRequest->difficulty
        );

        $quizData = json_decode($quiz, true) ?? [];
        $this->validateQuizFormat($quizData);

        return $quizData;
    }

    private function validateQuizFormat(array $quizData): void
    {
        if (!isset($quizData[self::EXPECTED_QUIZ_KEY]) || !is_array($quizData[self::EXPECTED_QUIZ_KEY])) {
            throw new QuizGenerationException('Invalid quiz format: missing or invalid quizzes key');
        }

        foreach ($quizData[self::EXPECTED_QUIZ_KEY] as $index => $question) {
            $this->validateQuestionFormat($question, $index);
        }
    }

    private function validateQuestionFormat(array $question, int $index): void
    {
        $requiredFields = ['question', 'options', 'answer'];
        foreach ($requiredFields as $field) {
            if (!isset($question[$field])) {
                throw new QuizGenerationException("Invalid question format at index {$index}: missing {$field}");
            }
        }

        if (!is_array($question['options']) || count($question['options']) < 2) {
            throw new QuizGenerationException("Invalid options format at index {$index}: insufficient options");
        }
    }

    private function createQuizModel(array $quizzes): QuizModel
    {
        return QuizModel::create([
            'quiz_request_id' => $this->quizRequest->id,
            'type' => $this->quizRequest->type,
            'question_count' => count($quizzes),
            'title' => $this->quizRequest->text,
        ]);
    }

    private function createQuestions(QuizModel $quizModel, array $questions): void
    {
        foreach ($questions as $question) {
            DB::transaction(function () use ($quizModel, $question) {
                $questionModel = $this->createQuestionModel($quizModel, $question);
                $this->createQuestionOptions($questionModel, $question);
            });
        }
    }

    private function createQuestionModel(QuizModel $quizModel, array $question): Question
    {
        return $quizModel->questions()->create([
            'text' => trim($question['question']),
        ]);
    }

    private function createQuestionOptions(Question $questionModel, array $question): void
    {
        $correctAnswer = trim($question['answer']);

        foreach ($question['options'] as $option) {
            $optionText = trim($option);
            $questionModel->options()->create([
                'text' => $optionText,
                'is_correct' => $this->isCorrectAnswer($correctAnswer, $optionText),
            ]);
        }
    }

    private function isCorrectAnswer(string $answer, string $option): bool
    {
        return $answer[0] === $option[0];
    }

    private function handleError(\Exception $e, string $message): void
    {
        $error = [
            'status' => $e->getCode(),
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString(),
        ];

        Log::error($message, $error);

        $this->updateQuizRequestStatus(Status::FAILED, $error);

        throw $e;
    }

    private function updateQuizRequestStatus(Status $status, array $reason = [], int $questionCount = 0): void
    {
        $this->quizRequest->update([
            'status' => $status,
            'reason' => empty($reason) ? null : json_encode($reason),
            'number_of_generated_question' => $questionCount,
        ]);

        broadcast(new QuizProgressUpdated($this->quizRequest))->toOthers();
    }

    private function checkQuizState(QuizRequest $quizRequest, Status $status = Status::PENDING): void
    {
        if ($quizRequest->status !== $status) {
            throw new QuizGenerationException("The quiz is not in {$status->value} state");
        }
    }
}
