<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\QuizRequest as QuizRequestModel;

class QuizProcessing extends Component
{
    public string $uuid;
    public int $progress = 0;
    public int $counter=0;

    public QuizRequestModel $quizRequestModel;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;

        $this->quizRequestModel = QuizRequestModel::where("uuid", $this->uuid)->first();

        $this->updateProgress();
    }

    public function updateProgress(): void
    {
        $this->counter++;

        $this->progress=100*$this->counter/$this->quizRequestModel->number_of_question->value;

    }

    public function render(): View
    {
        return view('livewire.quiz.processing.index', [
            'progress' => $this->progress,
            'quizRequestModel'=> $this->quizRequestModel,
        ]);
    }
}
