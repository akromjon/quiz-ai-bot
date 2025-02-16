<?php

namespace App\Http\Controllers;

use App\AI\Lib\QuizGenerator;
use App\Enum\Difficulty;
use App\Enum\Language;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class QuizRequestController extends Controller
{
    public function index(): View
    {
        return view('pages.quiz.request.index');
    }
}
