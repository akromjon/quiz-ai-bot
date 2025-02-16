<?php

declare(strict_types=1);

namespace App\Service;

use App\AI\Lib\QuizGenerator;
use App\Enum\Status;
use App\Models\Question;
use App\Models\QuizRequest;
use App\Models\Quiz as QuizModel;
use App\Exceptions\QuizGenerationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class QuizService
{
    private const EXPECTED_QUIZ_KEY = 'quizzes';

    /**
     * Create a new job instance.
     */
    public function __construct(protected QuizRequest $quizRequest)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            DB::transaction(function () {

                $this->checkQuizState($this->quizRequest);

                $this->updateQuizRequestStatus(Status::PROCESSING);

                $quizData = $this->generateQuiz();

                $this->validateQuizFormat($quizData);

                $quizModel = $this->createQuizModel($quizData[self::EXPECTED_QUIZ_KEY]);

                $this->createQuestions($quizModel, $quizData[self::EXPECTED_QUIZ_KEY]);

                $this->updateQuizRequestStatus(Status::COMPLETED);

            });

        } catch (QuizGenerationException $e) {

            $this->handleError($e, 'Quiz Generation Format Error');

        } catch (\Exception $e) {

            $this->handleError($e, 'Quiz Generation Failed');
        }
    }

    /**
     * Generate quiz using QuizGenerator.
     *
     * @return array
     */
    private function generateQuiz(): array
    {
        $quiz = QuizGenerator::generate(
            text: $this->quizRequest->text,
            numberOfQuizes: $this->quizRequest->number_of_question->value,
            language: $this->quizRequest->language,
            difficulty: $this->quizRequest->difficulty
        );

        return json_decode($quiz, true) ?? [];
    }

    /**
     * Validate the quiz format.
     *
     * @param array $quizData
     * @throws QuizGenerationException
     */
    private function validateQuizFormat(array $quizData): void
    {
        if (!isset($quizData[self::EXPECTED_QUIZ_KEY])) {
            throw new QuizGenerationException('Invalid quiz format: missing quizzes key');
        }
    }

    /**
     * Create the quiz model.
     *
     * @param array $quizzes
     * @return QuizModel
     */
    private function createQuizModel(array $quizzes): QuizModel
    {
        return QuizModel::create([
            'quiz_request_id' => $this->quizRequest->id,
            'type' => $this->quizRequest->type,
            'question_count' => count($quizzes),
            'title' => $this->quizRequest->text,
        ]);
    }

    /**
     * Create questions and their options.
     *
     * @param QuizModel $quizModel
     * @param array $questions
     */
    private function createQuestions(QuizModel $quizModel, array $questions): void
    {
        foreach ($questions as $question) {
            $questionModel = $this->createQuestionModel($quizModel, $question);
            $this->createQuestionOptions($questionModel, $question);
        }
    }

    /**
     * Create a single question model.
     *
     * @param QuizModel $quizModel
     * @param array $question
     * @return Question
     */
    private function createQuestionModel(QuizModel $quizModel, array $question): Question
    {
        return $quizModel->questions()->create([
            'text' => $question['question'],
        ]);
    }

    /**
     * Create options for a question.
     *
     * @param Question $questionModel
     * @param array $question
     */
    private function createQuestionOptions(Question $questionModel, array $question): void
    {
        foreach ($question['options'] as $option) {
            $questionModel->options()->create([
                'text' => $option,
                'is_correct' => $this->isCorrectAnswer($question['answer'], $option),
            ]);
        }
    }

    /**
     * Handle errors during quiz generation.
     *
     * @param \Exception $e
     * @param string $message
     */
    private function handleError(\Exception $e, string $message): void
    {
        $error = [
            'status' => $e->getCode(),
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ];

        Log::error($message, $error);

        $this->updateQuizRequestStatus(Status::FAILED, $error);
    }

    /**
     * Update QuizRequest status.
     *
     * @param Status $status
     * @param array $reason
     */
    private function updateQuizRequestStatus(Status $status, array $reason = []): void
    {
        $this->quizRequest->update([
            'status' => $status,
            'reason' => empty($reason) ? null : json_encode($reason),
        ]);
    }

    /**
     * Check if an option is the correct answer.
     *
     * @param string $answer
     * @param string $option
     * @return bool
     */
    private function isCorrectAnswer(string $answer, string $option): bool
    {
        return str_contains($option, $answer . '. ');
    }

    /**
     * Check if an quizrequest is pending state.
     *
     * @param QuizRequest $quizRequest
     * @return bool
     */
    private function checkQuizState(QuizRequest $quizRequest, Status $status = Status::PENDING): void
    {
        if ($quizRequest->status !== $status) {

            throw new QuizGenerationException("The quiz is not in {$status->value} state");

        }
    }


}
