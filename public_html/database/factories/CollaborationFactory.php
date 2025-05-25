<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collaboration>
 */
class CollaborationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => null,
            'user_id' => null,
            'status' => 'pending',
            'message' => fake()->paragraph(),
        ];
    }

    /**
     * Indicate that the collaboration request is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => \App\Models\Collaboration::STATUS_PENDING,
        ]);
    }

    /**
     * Indicate that the collaboration request is accepted.
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => \App\Models\Collaboration::STATUS_ACCEPTED,
        ]);
    }

    /**
     * Indicate that the collaboration request is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => \App\Models\Collaboration::STATUS_REJECTED,
        ]);
    }
} 