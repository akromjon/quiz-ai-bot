<?php

namespace App\Http\Controllers;

use App\AI\Lib\QuizGenerator;
use App\Enum\Difficulty;
use App\Enum\Language;
use Illuminate\Http\JsonResponse;

class QuizGeneratorController extends Controller
{
    public function generate(): JsonResponse
    {
        $text = "12go.asia";

        $quiz = QuizGenerator::generate(
            text: $text,
            numberOfQuizes: 5,
            language: Language::ENGLISH,
            difficulty: Difficulty::EXPERT
        );


        return response()->json(json_decode($quiz));
    }
}
