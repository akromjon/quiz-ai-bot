<?php

namespace App\Events;

use App\Models\QuizRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class QuizProgressUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(protected QuizRequest $quizRequest)
    {

    }

    public function broadcastOn()
    {
        return new Channel('quiz.' . $this->quizRequest->uuid);
    }
}

