<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class QuizProgressUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public string $uuid;
    public int $progress;
    public int $counter;

    public function __construct(string $uuid, int $progress, int $counter)
    {
        $this->uuid = $uuid;
        $this->progress = $progress;
        $this->counter = $counter;
    }

    public function broadcastOn()
    {
        return new Channel('quiz.' . $this->uuid);
    }
}

