<?php

namespace App\Jobs;

use App\Models\QuizRequest;
use App\Service\QuizService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class QuizGeneratorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;


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
        $quiz=new QuizService($this->quizRequest);

        $quiz->handle();
    }

}
