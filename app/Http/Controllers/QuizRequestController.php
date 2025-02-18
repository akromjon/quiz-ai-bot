<?php

namespace App\Http\Controllers;

use App\Service\WordService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class QuizRequestController extends Controller
{
    public function index(): View
    {
        return view('pages.quiz.request.index');
    }

    public function status(string $uuid): View
    {
        return view('pages.quiz.processing.index', ['uuid' => $uuid]);
    }

    public function completed(string $uuid): View
    {
        return view('pages.quiz.completed.index', ['uuid' => $uuid]);
    }

    public function word(string $uuid): JsonResponse|RedirectResponse
    {
        $wordPath = WordService::make()->get($uuid);

        if (empty($wordPath)) {
            return response()->json(status: 404);
        }

        return Redirect::to($wordPath);
    }

}
