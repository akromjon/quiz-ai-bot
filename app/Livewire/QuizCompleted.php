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
            Type::MULTIPLE_CHOICE => view('livewire.quiz.completed.multiple-choice.index', ['questions' => $quizRequestModel->quiz->questions]),
        };
    }
}
