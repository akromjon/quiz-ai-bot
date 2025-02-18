<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\QuizProgressUpdated;
use App\Models\QuizRequest;

class QuizProcessing extends Component
{
    public string $uuid;
    public int $progress = 0;
    public int $counter = 0;
    public QuizRequest $quizRequestModel;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
        $this->quizRequestModel = QuizRequest::where("uuid", $this->uuid)->first();
    }

    public function getListeners()
    {
        return [
            "echo:quiz.{$this->uuid},QuizProgressUpdated" => 'receiveProgressUpdate'
        ];
    }

    public function receiveProgressUpdate($payload): void
    {
        $this->progress = $payload['progress'];
        $this->counter = $payload['counter'];
    }

    public function render()
    {
        return view('livewire.quiz.processing.index', [
            'progress' => $this->progress,
        ]);
    }
}

