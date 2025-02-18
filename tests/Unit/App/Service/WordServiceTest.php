<?php

namespace Tests\Unit\App\Service;


use App\Service\QuizService;
use App\Service\WordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_can_be_created(): void
    {
        $doc=WordService::make()->get('37def825-8c50-4ac2-88c4-cbd20a2bfe30');
        dd($doc);
    }
}
