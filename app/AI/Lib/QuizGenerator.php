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

        $stream = $client->chat()->createStreamed([
            'model' => 'gpt-3.5-turbo-1106',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $text]
            ],
            'stream' => true,
            'response_format' => ['type' => 'json_object'],
        ]);

        $buffer = '';

        foreach ($stream as $response) {
            $chunk = $response->choices[0]->delta->content ?? '';
            $buffer .= $chunk;
            // // echo $chunk;
            // ob_flush();
            // flush();
        }

        // ob_get_clean();

        return $buffer;
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
