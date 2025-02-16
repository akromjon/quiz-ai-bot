<?php

namespace Tests\Unit\App\Playground;

use App\AI\Prompt\Quiz;
use App\Enum\Difficulty;
use App\Enum\Language;
use OpenAI;
use Tests\TestCase as TestsTestCase;

class OpenAITest extends TestsTestCase
{

    public function test_it_works(): void
    {
        $client = OpenAI::client(config('openai.api_key'));

        $text = 'PHP';
        $prompt = Quiz::get(5, Language::ENGLISH, Difficulty::ADVANCED);

        // OpenAI request with JSON mode enabled
        $stream = $client->chat()->createStreamed([
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $text]
            ],
            'stream' => true,
            'response_format' => ['type' => 'json_object'], // ✅ Enforces JSON output
        ]);

        $buffer = ''; // To accumulate the streaming JSON response

        foreach ($stream as $response) {
            $chunk = $response->choices[0]->delta->content ?? '';
            $buffer .= $chunk;
            echo $chunk;
            ob_flush();
            flush();
        }

        $this->assertJson($buffer); // ✅ Ensure response is valid JSON
    }

}
