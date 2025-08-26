<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/exam/select', [\App\Http\Controllers\ExamController::class, 'selectLevel'])->name('exam.select');
Route::get('/exam', [\App\Http\Controllers\ExamController::class, 'show'])->name('exam.show');

Route::post('/exam/submit', [\App\Http\Controllers\ExamController::class, 'submit'])->name('exam.submit');

Route::get('/questions/manage', [\App\Http\Controllers\ExamController::class, 'manageQuestions'])->name('questions.manage');
Route::post('/questions/store', [\App\Http\Controllers\ExamController::class, 'storeQuestion'])->name('questions.store');
Route::post('/questions/{id}/update', [\App\Http\Controllers\ExamController::class, 'updateQuestion'])->name('questions.update');
