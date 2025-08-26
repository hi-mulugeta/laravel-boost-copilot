<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
    \DB::table('questions')->truncate();
    \DB::table('exams')->truncate();
        $beginner = Exam::create(['name' => 'Laravel Beginner Exam', 'level' => 'beginner']);
        $intermediate = Exam::create(['name' => 'Laravel Intermediate Exam', 'level' => 'intermediate']);
        $advanced = Exam::create(['name' => 'Laravel Advanced Exam', 'level' => 'advanced']);

        $beginnerQuestions = [
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

        $intermediateQuestions = [
            [
                'title' => 'Which method is used to eager load relationships?',
                'description' => 'Select the correct Eloquent method.',
                'choice_a' => 'with()',
                'choice_b' => 'load()',
                'choice_c' => 'attach()',
                'choice_d' => 'sync()',
                'correct_choice' => 'a',
            ],
            [
                'title' => 'How do you define a one-to-many relationship?',
                'description' => 'Choose the correct Eloquent method.',
                'choice_a' => 'hasOne()',
                'choice_b' => 'belongsTo()',
                'choice_c' => 'hasMany()',
                'choice_d' => 'belongsToMany()',
                'correct_choice' => 'c',
            ],
            [
                'title' => 'Which file configures database connections?',
                'description' => 'Pick the correct config file.',
                'choice_a' => 'config/database.php',
                'choice_b' => 'config/app.php',
                'choice_c' => 'config/auth.php',
                'choice_d' => 'config/filesystems.php',
                'correct_choice' => 'a',
            ],
            [
                'title' => 'How do you run a queued job?',
                'description' => 'Choose the correct Artisan command.',
                'choice_a' => 'php artisan queue:work',
                'choice_b' => 'php artisan job:run',
                'choice_c' => 'php artisan run:queue',
                'choice_d' => 'php artisan queue:listen',
                'correct_choice' => 'a',
            ],
            [
                'title' => 'Which method updates a model in Eloquent?',
                'description' => 'Select the correct method.',
                'choice_a' => 'update()',
                'choice_b' => 'save()',
                'choice_c' => 'edit()',
                'choice_d' => 'patch()',
                'correct_choice' => 'a',
            ],
        ];

        $advancedQuestions = [
            [
                'title' => 'How do you create a custom Blade directive?',
                'description' => 'Choose the correct method.',
                'choice_a' => 'Blade::directive()',
                'choice_b' => 'Blade::custom()',
                'choice_c' => 'Blade::make()',
                'choice_d' => 'Blade::register()',
                'correct_choice' => 'a',
            ],
            [
                'title' => 'Which event is fired when a model is deleted?',
                'description' => 'Pick the correct event.',
                'choice_a' => 'deleted',
                'choice_b' => 'deleting',
                'choice_c' => 'removing',
                'choice_d' => 'removed',
                'correct_choice' => 'b',
            ],
            [
                'title' => 'How do you define a polymorphic relationship?',
                'description' => 'Choose the correct Eloquent method.',
                'choice_a' => 'morphTo()',
                'choice_b' => 'hasPolymorphic()',
                'choice_c' => 'polymorphic()',
                'choice_d' => 'morphMany()',
                'correct_choice' => 'a',
            ],
            [
                'title' => 'Which command publishes vendor assets?',
                'description' => 'Select the correct Artisan command.',
                'choice_a' => 'php artisan vendor:publish',
                'choice_b' => 'php artisan asset:publish',
                'choice_c' => 'php artisan publish:vendor',
                'choice_d' => 'php artisan vendor:assets',
                'correct_choice' => 'a',
            ],
            [
                'title' => 'How do you use Laravel Macros?',
                'description' => 'Choose the correct usage.',
                'choice_a' => 'Macroable trait',
                'choice_b' => 'MacroTrait',
                'choice_c' => 'Macroable class',
                'choice_d' => 'Macroable interface',
                'correct_choice' => 'a',
            ],
        ];

        foreach ($beginnerQuestions as $q) {
            $beginner->questions()->create($q);
        }
        foreach ($intermediateQuestions as $q) {
            $intermediate->questions()->create($q);
        }
        foreach ($advancedQuestions as $q) {
            $advanced->questions()->create($q);
        }
    // Removed duplicate and misplaced code block
    }
}
