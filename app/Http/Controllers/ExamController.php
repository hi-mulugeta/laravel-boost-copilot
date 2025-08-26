<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function show(): \Inertia\Response
    {
        $exam = Exam::with('questions')->first();
        return Inertia::render('Exam/Show', [
            'exam' => $exam,
        ]);
    }

    public function submit(Request $request): \Inertia\Response
    {
        $exam = Exam::with('questions')->findOrFail($request->input('exam_id'));
        $answers = $request->input('answers', []);
        $score = 0;
        foreach ($exam->questions as $question) {
            if (($answers[$question->id] ?? null) === $question->correct_choice) {
                $score++;
            }
        }
        $percent = round(($score / $exam->questions->count()) * 100);
        $message = "You scored {$score}/{$exam->questions->count()}, that's {$percent}%. ";
        if ($percent === 100) {
            $message .= 'Great job!';
        } elseif ($percent >= 80) {
            $message .= 'Well done!';
        } else {
            $message .= 'Keep practicing!';
        }
        return Inertia::render('Exam/Result', [
            'score' => $score,
            'total' => $exam->questions->count(),
            'percent' => $percent,
            'message' => $message,
        ]);
    }
}
