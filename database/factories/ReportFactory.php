<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reporter_id' => null,
            'reported_id' => null,
            'reason' => fake()->sentence(),
            'notes' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['pending', 'resolved']),
        ];
    }
} 