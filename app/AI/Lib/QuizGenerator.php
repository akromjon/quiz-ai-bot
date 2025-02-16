<?php

namespace App\AI\Lib;

use App\AI\Prompt\Quiz;
use App\Enum\Difficulty;
use App\Enum\Language;
use OpenAI\Client;
use OpenAI;

final class QuizGenerator
{
    public static function generate(string $text, int $numberOfQuizes, Language $language, Difficulty $difficulty): string
    {
        $client = self::getClient();

        $prompt = self::makePrompt($numberOfQuizes, $language, $difficulty);

        // Request OpenAI response (non-streaming)
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $text]
            ],
            'response_format' => ['type' => 'json_object'], // ✅ Enforces JSON output
        ]);

        // Extract response content
        $quizData = $response->choices[0]->message->content ?? '';

        return $quizData;
    }

    private static function getClient(): Client
    {
        return OpenAI::client(config('openai.api_key'));
    }

    private static function makePrompt(int $numberOfQuizes, Language $language, Difficulty $difficulty): string
    {
        return Quiz::get($numberOfQuizes, $language, $difficulty);
    }
}
