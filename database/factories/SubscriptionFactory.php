<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2, 0, 99),
            'option1' => fake()->boolean(),
            'option2' => fake()->boolean(),
            'option3' => fake()->boolean(),
            'option4' => fake()->boolean(),
            'option5' => fake()->boolean(),
            'option6' => fake()->boolean(),
            'option7' => fake()->boolean(),
            'option8' => fake()->boolean(),
            'option9' => fake()->boolean(),
            'option10' => fake()->boolean(),
        ];
    }
}
