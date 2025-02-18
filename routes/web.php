<?php

use App\Events\QuizProgressUpdated;
use App\Http\Controllers\QuizRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function (): void {
    Route::get('/', [QuizRequestController::class, 'index']);

    Route::get('/{uuid}/quiz', [QuizRequestController::class, 'show']);
    Route::get('/{uuid}/{counter}/play', function ($uuid,$counter) {


        broadcast(new QuizProgressUpdated($uuid, 1, $counter))->toOthers();

    });


});
