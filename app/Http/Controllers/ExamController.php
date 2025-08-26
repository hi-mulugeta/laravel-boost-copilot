<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExamController extends Controller
{

    public function selectLevel(): \Inertia\Response
    {
        return Inertia::render('Exam/SelectLevel');
    }

    public function show(Request $request): \Inertia\Response
    {
        $level = $request->query('level');
        if (!$level) {
            return Inertia::render('Exam/SelectLevel');
        }
        $exam = Exam::where('level', $level)->first();
        if (!$exam) {
            return Inertia::render('Exam/EmptyState', [
                'level' => $level,
            ]);
        }
        // Get 5 random questions for this level
        $questions = $exam->questions()->inRandomOrder()->limit(5)->get();
        $exam->setRelation('questions', $questions);
        return Inertia::render('Exam/Show', [
            'exam' => $exam,
            'level' => $level,
        ]);
    }

    public function manageQuestions(Request $request): \Inertia\Response
    {
        $levels = Exam::pluck('level')->unique()->values();
        $exams = Exam::all();
        $questions = \App\Models\Question::all();
        return Inertia::render('Exam/ManageQuestions', [
            'levels' => $levels,
            'exams' => $exams,
            'questions' => $questions,
        ]);
    }

    public function storeQuestion(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'exists:exams,id'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'choice_a' => ['required', 'string'],
            'choice_b' => ['required', 'string'],
            'choice_c' => ['required', 'string'],
            'choice_d' => ['required', 'string'],
            'correct_choice' => ['required', 'in:a,b,c,d'],
        ]);
        \App\Models\Question::create($validated);
        return redirect()->back()->with('success', 'Question added successfully!');
    }

    public function updateQuestion(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $question = \App\Models\Question::findOrFail($id);
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'choice_a' => ['required', 'string'],
            'choice_b' => ['required', 'string'],
            'choice_c' => ['required', 'string'],
            'choice_d' => ['required', 'string'],
            'correct_choice' => ['required', 'in:a,b,c,d'],
        ]);
        $question->update($validated);
        return redirect()->back()->with('success', 'Question updated successfully!');
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
