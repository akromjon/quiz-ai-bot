<?php

namespace App\AI\Prompt;

use App\Enum\Language;
use App\Enum\Difficulty;

final class Quiz
{
    public static function get(int $numberOfQuizes, Language $language, Difficulty $difficulty): string
    {
        return <<<PROMPT
        You are an AI that generates letter-based multiple-choice quizzes.

        Instructions:
        - Generate {$numberOfQuizes} quiz questions at the {$difficulty->value} difficulty level.
        - The questions should be based on the provided text.
        - The output should be structured strictly as JSON.
        - The response must exactly match this format:

        ```json
        {
            "quizzes": [
                {
                    "question": "Your question here?",
                    "options": ["A. Option", "B. Option", "C. Option", "D. Option"],
                    "answer": "A"
                }
            ]
        }
        ```

        - Only return a valid JSON object.
        - Do not include explanations or additional text.

        Now, generate the quizzes in {$language->value} based on the given text.
        PROMPT;
    }
}

