<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/exam/select', [\App\Http\Controllers\ExamController::class, 'selectLevel'])->name('exam.select');
Route::get('/exam', [\App\Http\Controllers\ExamController::class, 'show'])->name('exam.show');
Route::post('/exam/submit', [\App\Http\Controllers\ExamController::class, 'submit'])->name('exam.submit');
