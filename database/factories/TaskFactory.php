<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Column;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'column_id' => Column::factory(),
            'nom' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'priority' => $this->faker->randomElement(['basse', 'moyenne', 'élevée']),
            'order' => $this->faker->numberBetween(1, 20),
            'date_limite' => $this->faker->optional()->date(),
            'completed_at' => $this->faker->boolean(50) ? now() : null,
        ];
    }
}
