<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
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

        User::factory(100)->create();
    }
}
