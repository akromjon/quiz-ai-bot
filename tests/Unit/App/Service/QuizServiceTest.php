<?php

namespace Tests\Unit\App\Service;


use App\Models\QuizRequest;
use App\Service\QuizService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizServiceTest extends TestCase
{
    use RefreshDatabase;

    private QuizService $quizService;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_can_create_a_quiz_request(): void
    {
        $quizRequest = QuizRequest::factory()->create();

        $this->assertInstanceOf(QuizRequest::class, $quizRequest);

        $this->assertDatabaseHas('quiz_requests', [
            'id' => $quizRequest->id,
        ]);
    }

    public function test_it_can_create_a_quiz_with_quiz_request(): void
    {
        $quizRequest = QuizRequest::factory()->pending()->create();

        $this->assertInstanceOf(QuizRequest::class, $quizRequest);

        $quiz = new QuizService($quizRequest);

        $quiz->handle();

        $this->assertDatabaseHas('quizzes', [
            'quiz_request_id' => $quizRequest->id,
            'type' => $quizRequest->type,
            'title' => $quizRequest->text
        ]);
    }


}
