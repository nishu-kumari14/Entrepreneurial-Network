<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\ForumPost;

class ForumCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'post_id' => ForumPost::factory(),
            'content' => fake()->paragraph(),
            'parent_id' => null,
        ];
    }
} 