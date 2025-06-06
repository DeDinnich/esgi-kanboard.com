<?php

namespace Database\Factories;

use App\Models\ProjectCollaborateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectCollaborateurFactory extends Factory
{
    protected $model = ProjectCollaborateur::class;

    public function definition(): array
    {
        return [
            'project_id' => null, // assigné manuellement dans le seeder
            'user_id' => null,    // assigné manuellement dans le seeder
        ];
    }
}
