<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Models\QuizRequest as QuizRequestModel;
use Illuminate\Contracts\View\View;

class QuizRequestController extends Controller
{
    public function index(): View
    {
        return view('pages.quiz.request.index');
    }

    public function show(string $uuid): View
    {
        $quizRequest = QuizRequestModel::where('uuid', $uuid)->firstOrFail();

        return $this->getViewByStatus($quizRequest, $uuid);
    }

    private function getViewByStatus(QuizRequestModel $quizRequestModel, string $uuid): View
    {
        return match ($quizRequestModel->status) {
            Status::PROCESSING => view('pages.quiz.processing.index', ['uuid' => $uuid]),
            Status::FAILED => view('pages.quiz.failed.index', ['uuid' => $uuid]),
            Status::COMPLETED => view('pages.quiz.completed.index', ['uuid' => $uuid]),
            default => view('pages.quiz.processing.index', ['uuid' => $uuid]),
        };
    }
}
