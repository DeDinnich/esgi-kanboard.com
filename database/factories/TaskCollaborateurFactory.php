<?php

namespace Database\Factories;

use App\Models\TaskCollaborateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskCollaborateurFactory extends Factory
{
    protected $model = TaskCollaborateur::class;

    public function definition(): array
    {
        return [
            'task_id' => null, // assigné manuellement dans le seeder
            'user_id' => null,
        ];
    }
}
