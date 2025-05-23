<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Alex Johnson',
                'email' => 'alex@example.com',
                'password' => Hash::make('password'),
                'role' => 'entrepreneur',
                'skills' => ['Web Development', 'Product Management', 'Marketing'],
                'bio' => 'Tech entrepreneur with 5+ years of experience in building SaaS products',
                'location' => 'San Francisco, USA',
            ],
            [
                'name' => 'Sarah Chen',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'role' => 'investor',
                'skills' => ['Finance', 'Investment Analysis', 'Business Strategy'],
                'bio' => 'Angel investor and startup advisor with a focus on fintech and AI',
                'location' => 'New York, USA',
            ],
            [
                'name' => 'Michael Rodriguez',
                'email' => 'michael@example.com',
                'password' => Hash::make('password'),
                'role' => 'mentor',
                'skills' => ['Leadership', 'Business Development', 'Sales'],
                'bio' => 'Serial entrepreneur and business mentor with 15+ years of experience',
                'location' => 'Austin, USA',
            ],
            [
                'name' => 'Emma Wilson',
                'email' => 'emma@example.com',
                'password' => Hash::make('password'),
                'role' => 'entrepreneur',
                'skills' => ['UI/UX Design', 'Mobile Development', 'Project Management'],
                'bio' => 'Product designer and startup founder passionate about user experience',
                'location' => 'London, UK',
            ],
            [
                'name' => 'David Kim',
                'email' => 'david@example.com',
                'password' => Hash::make('password'),
                'role' => 'investor',
                'skills' => ['Venture Capital', 'Market Analysis', 'Startup Valuation'],
                'bio' => 'VC partner specializing in early-stage tech startups',
                'location' => 'Singapore',
            ],
        ];

        foreach ($users as $userData) {
            $skills = $userData['skills'];
            unset($userData['skills']);
            
            $user = User::create($userData);

            // Attach skills to user
            foreach ($skills as $skillName) {
                $skill = Skill::firstOrCreate(['name' => $skillName]);
                $user->skills()->attach($skill->id, [
                    'level' => fake()->randomElement(['beginner', 'intermediate', 'advanced', 'expert']),
                    'experience_years' => fake()->numberBetween(1, 10)
                ]);
            }
        }
    }
} 