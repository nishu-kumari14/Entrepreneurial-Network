<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ForumLikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,
            'forum_post_id' => null,
            'type' => fake()->randomElement(['like', 'dislike']),
        ];
    }
} 