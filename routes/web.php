<?php

use App\Events\QuizProgressUpdated;
use App\Http\Controllers\QuizRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function (): void {
    Route::get('/', [QuizRequestController::class, 'index'])->name('main');

    Route::get('/{uuid}/status', [QuizRequestController::class, 'status'])->name('quiz.status');
    Route::get('/{uuid}/completed', [QuizRequestController::class, 'completed'])->name('quiz.completed');
    Route::get('/{uuid}.docx', [QuizRequestController::class, 'word'])->name('quiz.word');
    Route::get('/{uuid}.pdf', [QuizRequestController::class, 'pdf'])->name('quiz.pdf');
    Route::get('/{user_uuid}/list', [QuizRequestController::class, 'list'])->name('quiz.list');




    // Route::get('/{uuid}/{counter}/play', function ($uuid,$counter) {


    //     broadcast(new QuizProgressUpdated($uuid, 1, $counter))->toOthers();

    // });


});
