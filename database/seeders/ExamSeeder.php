<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $exam = Exam::create(['name' => 'Laravel Beginner Exam']);

        $questions = [
            [
                'title' => 'What is Laravel?',
                'description' => 'Choose the best description of Laravel.',
                'choice_a' => 'A JavaScript framework',
                'choice_b' => 'A PHP framework',
                'choice_c' => 'A CSS library',
                'choice_d' => 'A database engine',
                'correct_choice' => 'b',
            ],
            [
                'title' => 'Which command creates a new Laravel project?',
                'description' => 'Select the correct Artisan command.',
                'choice_a' => 'php artisan make:project',
                'choice_b' => 'php new laravel',
                'choice_c' => 'laravel new project',
                'choice_d' => 'composer create-project laravel/laravel',
                'correct_choice' => 'd',
            ],
            [
                'title' => 'Where are Laravel routes defined?',
                'description' => 'Pick the correct file.',
                'choice_a' => 'routes/web.php',
                'choice_b' => 'app/Http/routes.php',
                'choice_c' => 'config/routes.php',
                'choice_d' => 'resources/routes.php',
                'correct_choice' => 'a',
            ],
            [
                'title' => 'Which Eloquent method retrieves all records?',
                'description' => 'Select the correct method.',
                'choice_a' => 'get()',
                'choice_b' => 'all()',
                'choice_c' => 'find()',
                'choice_d' => 'first()',
                'correct_choice' => 'b',
            ],
            [
                'title' => 'How do you run database migrations?',
                'description' => 'Choose the correct command.',
                'choice_a' => 'php artisan migrate',
                'choice_b' => 'php migrate',
                'choice_c' => 'php artisan db:migrate',
                'choice_d' => 'php artisan make:migration',
                'correct_choice' => 'a',
            ],
        ];

        foreach ($questions as $q) {
            $exam->questions()->create($q);
        }
    }
}
