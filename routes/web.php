<?php

use App\Http\Controllers\QuizRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function (): void {
    Route::get('/', [QuizRequestController::class, 'index']);

    Route::get('/{uuid}/quiz', [QuizRequestController::class, 'show']);

});
