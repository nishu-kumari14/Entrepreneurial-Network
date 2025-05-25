<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sender_id' => null,
            'receiver_id' => null,
            'content' => fake()->paragraph(),
            'read_at' => fake()->optional()->dateTime(),
        ];
    }
} 