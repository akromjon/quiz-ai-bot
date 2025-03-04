<?php

namespace App\Livewire;

use App\Enum\Type;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\QuizRequest as QuizRequestModel;

class QuizCompleted extends Component
{
    public string $uuid;
    public QuizRequestModel $quizRequestModel;
    public array $selectedAnswers = [];
    public array $results = [];
    public bool $isSubmitted = false;
    public int $correctCount = 0;
    public int $totalQuestions = 0;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
        $this->quizRequestModel = QuizRequestModel::where('uuid', $uuid)->first();
    }

    public function render(): View
    {
        return $this->getViewByQuizType(quizRequestModel: $this->quizRequestModel);
    }

    private function getViewByQuizType(QuizRequestModel $quizRequestModel): View
    {
        return match ($quizRequestModel->type) {
            Type::MULTIPLE_CHOICE => view('livewire.quiz.completed.multiple-choice.index', [
                'quizzes' => $quizRequestModel->quizzes,
                'results' => $this->results,
                'isSubmitted' => $this->isSubmitted,
                'correctCount' => $this->correctCount,
                'totalQuestions' => $this->totalQuestions,
            ]),
        };
    }

    public function submit(): void
    {
        $this->validate([
            'selectedAnswers.*' => 'required',
        ], [
            'selectedAnswers.*.required' => 'Iltimos, barcha savollarga javob bering',
        ]);

        $this->results = [];
        $this->correctCount = 0;
        $this->totalQuestions = 0;

        foreach ($this->quizRequestModel->quizzes as $quiz) {
            foreach ($quiz->questions as $question) {
                $this->totalQuestions++;
                $selectedOptionId = $this->selectedAnswers[$question->id] ?? null;

                $correctOption = $question->options->where('is_correct', true)->first();
                $selectedOption = $question->options->where('id', $selectedOptionId)->first();

                $isCorrect = $selectedOption && $selectedOption->is_correct;

                if ($isCorrect) {
                    $this->correctCount++;
                }

                $this->results[$question->id] = [
                    'isCorrect' => $isCorrect,
                    'correctOptionId' => $correctOption->id,
                    'selectedOptionId' => $selectedOptionId,
                ];
            }
        }

        $this->isSubmitted = true;
    }
}
