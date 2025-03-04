<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Models\QuizRequest;
use App\Service\PdfService;
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

    public function pdf(string $uuid): JsonResponse|RedirectResponse
    {
        $pdfPath = PdfService::make()->get($uuid);

        if (empty($pdfPath)) {
            return response()->json(status: 404);
        }

        return Redirect::to($pdfPath);
    }

    public function list(string $userUuid): View|JsonResponse
    {
        $quizRequests = QuizRequest::where('user_id', $userUuid)
            ->where('status',Status::COMPLETED)
            ->orderBy('created_at','desc')
            ->paginate(30);

        if ($quizRequests->isEmpty()) {
            return response()->json(status: 404);
        }

        return view('pages.quiz.list.index', ['quiz_requests' => $quizRequests]);
    }

}
