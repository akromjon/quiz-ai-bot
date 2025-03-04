<?php

namespace App\AI\Lib;

use App\AI\Model\Model;
use App\AI\Prompt\Quiz;
use App\Enum\Difficulty;
use App\Enum\Language;
use OpenAI\Client;
use OpenAI;
use InvalidArgumentException;
use RuntimeException;
use JsonException;

final class QuizGenerator
{
    private static ?self $instance = null;
    private Client $client;
    /**
     * Private constructor to prevent direct creation
     *
     * @throws RuntimeException If OpenAI client creation fails
     */
    private function __construct()
    {
        $apiKey = config('openai.api_key');

        if (empty($apiKey)) {

            throw new RuntimeException('OpenAI API key not configured');
        }

        $this->client = OpenAI::client($apiKey);
    }

    /**
     * Prevent cloning of the instance
     */
    private function __clone()
    {
    }

    /**
     * Prevent unserialize of the instance
     */
    public function __wakeup()
    {
        throw new RuntimeException('Cannot unserialize singleton');
    }

    /**
     * Gets the singleton instance of QuizGenerator
     *
     * @return self
     */
    public static function make(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Generates quiz questions based on the provided text
     *
     * @param string $text Input text to generate questions from
     * @param int $numberOfQuizes Number of questions to generate
     * @param Language $language Language for the questions
     * @param Difficulty $difficulty Difficulty level
     * @return array JSON array containing quiz data
     * @throws RuntimeException If API call fails
     * @throws JsonException If JSON parsing fails
     */
    public function generate(
        Model $model,
        string $text,
        int $numberOfQuizes,
        Language $language,
        Difficulty $difficulty
    ): array {
        if (empty($text)) {
            throw new InvalidArgumentException('Input text cannot be empty');
        }

        if ($numberOfQuizes < 1) {
            throw new InvalidArgumentException('Number of quizzes must be positive');
        }

        $prompt = $this->makePrompt($numberOfQuizes, $language, $difficulty);

        try {
            $response = $this->client->chat()->create([
                'model' => $model->value,
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => $text]
                ],
                'response_format' => ['type' => 'json_object'],
            ]);

            $responseContent = $response->choices[0]->message->content ?? '';

            if (empty($responseContent)) {
                throw new RuntimeException('Empty response received from OpenAI');
            }

            $quizDataArray = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);

            $quizDataArray['token_usage'] = [
                'model'=> $model,
                'prompt_tokens' => $response->usage->promptTokens,
                'completion_tokens' => $response->usage->completionTokens,
                'total_tokens' => $response->usage->totalTokens
            ];

            return $quizDataArray;

        } catch (\Exception $e) {
            throw new RuntimeException(
                "Failed to generate quiz: {$e->getMessage()}",
                0,
                $e
            );
        }
    }

    /**
     * Creates the prompt for quiz generation
     *
     * @param int $numberOfQuizes
     * @param Language $language
     * @param Difficulty $difficulty
     * @return string
     */
    private function makePrompt(
        int $numberOfQuizes,
        Language $language,
        Difficulty $difficulty
    ): string {
        return Quiz::get($numberOfQuizes, $language, $difficulty);
    }
}
