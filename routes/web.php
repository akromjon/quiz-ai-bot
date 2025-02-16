<?php

use App\Http\Controllers\QuizGeneratorController;
use Illuminate\Support\Facades\Route;

Route::get('quiz', [QuizGeneratorController::class, 'generate'])->name('quiz.generate');
