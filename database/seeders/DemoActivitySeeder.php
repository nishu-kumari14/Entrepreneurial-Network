<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use App\Models\Project;
use App\Models\ForumPost;
use App\Models\Collaboration;
use Illuminate\Database\Seeder;

class DemoActivitySeeder extends Seeder
{
    public function run()
    {
        $activities = [
            // Project-related activities
            [
                'user_email' => 'alex@example.com',
                'type' => 'project_created',
                'subject_type' => Project::class,
                'subject_title' => 'Eco-Friendly Marketplace',
                'created_at' => now()->subDays(10),
            ],
            [
                'user_email' => 'emma@example.com',
                'type' => 'project_created',
                'subject_type' => Project::class,
                'subject_title' => 'AI-Powered Learning Platform',
                'created_at' => now()->subDays(8),
            ],
            [
                'user_email' => 'michael@example.com',
                'type' => 'project_updated',
                'subject_type' => Project::class,
                'subject_title' => 'HealthTech Wearable App',
                'created_at' => now()->subDays(5),
            ],

            // Forum-related activities
            [
                'user_email' => 'sarah@example.com',
                'type' => 'forum_post_created',
                'subject_type' => ForumPost::class,
                'subject_title' => 'Best Practices for Seed Funding',
                'created_at' => now()->subDays(7),
            ],
            [
                'user_email' => 'david@example.com',
                'type' => 'forum_post_created',
                'subject_type' => ForumPost::class,
                'subject_title' => 'Legal Requirements for FinTech Startup',
                'created_at' => now()->subDays(6),
            ],
            [
                'user_email' => 'emma@example.com',
                'type' => 'forum_comment_created',
                'subject_type' => ForumPost::class,
                'subject_title' => 'Growth Hacking Strategies for B2B SaaS',
                'created_at' => now()->subDays(4),
            ],

            // Collaboration-related activities
            [
                'user_email' => 'michael@example.com',
                'type' => 'collaboration_requested',
                'subject_type' => Collaboration::class,
                'subject_title' => 'Eco-Friendly Marketplace',
                'created_at' => now()->subDays(3),
            ],
            [
                'user_email' => 'david@example.com',
                'type' => 'collaboration_accepted',
                'subject_type' => Collaboration::class,
                'subject_title' => 'AI-Powered Learning Platform',
                'created_at' => now()->subDays(2),
            ],
            [
                'user_email' => 'sarah@example.com',
                'type' => 'collaboration_rejected',
                'subject_type' => Collaboration::class,
                'subject_title' => 'HealthTech Wearable App',
                'created_at' => now()->subDays(1),
            ],

            // Profile-related activities
            [
                'user_email' => 'alex@example.com',
                'type' => 'profile_updated',
                'subject_type' => User::class,
                'subject_title' => 'Alex Johnson',
                'created_at' => now()->subDays(9),
            ],
            [
                'user_email' => 'emma@example.com',
                'type' => 'skills_updated',
                'subject_type' => User::class,
                'subject_title' => 'Emma Wilson',
                'created_at' => now()->subDays(6),
            ],
        ];

        foreach ($activities as $activity) {
            $user_email = $activity['user_email'];
            $subject_type = $activity['subject_type'];
            $subject_title = $activity['subject_title'];
            unset($activity['user_email'], $activity['subject_type'], $activity['subject_title']);
            
            $user = User::where('email', $user_email)->first();
            
            if ($user) {
                $subject = null;
                if ($subject_type === Project::class) {
                    $subject = Project::where('title', $subject_title)->first();
                } elseif ($subject_type === ForumPost::class) {
                    $subject = ForumPost::where('title', $subject_title)->first();
                } elseif ($subject_type === Collaboration::class) {
                    $subject = Collaboration::whereHas('project', function($query) use ($subject_title) {
                        $query->where('title', $subject_title);
                    })->first();
                } elseif ($subject_type === User::class) {
                    $subject = User::where('name', $subject_title)->first();
                }
                
                if ($subject) {
                    Activity::create(array_merge($activity, [
                        'user_id' => $user->id,
                        'subject_type' => $subject_type,
                        'subject_id' => $subject->id,
                    ]));
                }
            }
        }
    }
} 