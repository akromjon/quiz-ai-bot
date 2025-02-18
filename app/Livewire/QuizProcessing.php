<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\QuizProgressUpdated;
use App\Models\QuizRequest;

class QuizProcessing extends Component
{
    public string $uuid;
    public QuizRequest $quizRequestModel;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;

        $this->quizRequestModel = QuizRequest::where("uuid", $this->uuid)->firstOrFail();
    }

    public function getListeners()
    {
        return [
            "echo:quiz.{$this->uuid},QuizProgressUpdated"
        ];
    }

    public function render()
    {
        return view('livewire.quiz.status.index');
    }
}

