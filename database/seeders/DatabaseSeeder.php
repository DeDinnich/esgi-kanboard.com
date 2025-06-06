<?php

namespace Database\Seeders;

use App\Models\Column;
use App\Models\Project;
use App\Models\ProjectCollaborateur;
use App\Models\Subscription;
use App\Models\Task;
use App\Models\TaskCollaborateur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crée les abonnements
        $plans = [
            [
                'id' => Str::uuid(),
                'name' => 'Gratuit',
                'price' => 0,
                'option1' => true,
                'option2' => false,
                'option3' => false,
                'option4' => false,
                'option5' => false,
                'option6' => false,
                'option7' => false,
                'option8' => false,
                'option9' => false,
                'option10' => false,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Standard',
                'price' => 9.99,
                'option1' => true,
                'option2' => true,
                'option3' => true,
                'option4' => false,
                'option5' => false,
                'option6' => false,
                'option7' => false,
                'option8' => false,
                'option9' => false,
                'option10' => false,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pro',
                'price' => 19.99,
                'option1' => true,
                'option2' => true,
                'option3' => true,
                'option4' => true,
                'option5' => true,
                'option6' => true,
                'option7' => true,
                'option8' => true,
                'option9' => true,
                'option10' => true,
            ]
        ];
        foreach ($plans as $plan) {
            Subscription::create($plan);
        }

        // Crée 1000 utilisateurs
        $users = User::factory(50)->create();

        // Création de projets
        $users->each(function ($user) use ($users) {
            $nbProjects = rand(0, 10);
            Project::factory($nbProjects)->create([
                'user_id' => $user->id,
            ])->each(function ($project) use ($users) {
                // Archivage aléatoire (20%)
                if (rand(1, 100) <= 20) {
                    $project->delete();
                }

                // Collaborateurs (excluant l’owner)
                $collaborators = $users->where('id', '!=', $project->user_id)
                                       ->random(rand(1, 10));
                foreach ($collaborators as $collab) {
                    ProjectCollaborateur::factory()->create([
                        'project_id' => $project->id,
                        'user_id' => $collab->id,
                    ]);
                }

                // Colonnes
                Column::factory(rand(2, 20))->create([
                    'project_id' => $project->id,
                    'user_id' => $project->user_id,
                ])->each(function ($column) use ($users, $project) {
                    // Tâches
                    Task::factory(rand(0, 20))->create([
                        'column_id' => $column->id,
                        'user_id' => $column->user_id,
                    ])->each(function ($task) use ($users, $project) {
                        // Collaborateurs des tâches (hors créateur)
                        $collabs = $users->where('id', '!=', $task->user_id)
                                         ->random(rand(1, 5));
                        foreach ($collabs as $user) {
                            TaskCollaborateur::factory()->create([
                                'task_id' => $task->id,
                                'user_id' => $user->id,
                            ]);
                        }
                    });
                });
            });
        });
    }
}
