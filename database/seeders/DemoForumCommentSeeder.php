<?php

namespace Database\Seeders;

use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoForumCommentSeeder extends Seeder
{
    public function run()
    {
        $comments = [
            // Comments for "Looking for Co-founder for AI Startup"
            [
                'content' => 'I have experience in machine learning and web development. Would love to learn more about your vision and the current state of the project. What tech stack are you planning to use?',
                'post_title' => 'Looking for Co-founder for AI Startup',
                'author_email' => 'emma@example.com',
            ],
            [
                'content' => 'This sounds like an interesting project! Have you already validated the market need? I\'d be interested in hearing about your research.',
                'post_title' => 'Looking for Co-founder for AI Startup',
                'author_email' => 'michael@example.com',
            ],

            // Comments for "Best Practices for Seed Funding"
            [
                'content' => 'Focus on traction metrics and clear market opportunity in your pitch deck. Happy to review it if you\'d like.',
                'post_title' => 'Best Practices for Seed Funding',
                'author_email' => 'david@example.com',
            ],
            [
                'content' => 'We recently closed our seed round. The key was having a strong MVP and early customer testimonials.',
                'post_title' => 'Best Practices for Seed Funding',
                'author_email' => 'alex@example.com',
            ],

            // Comments for "Growth Hacking Strategies for B2B SaaS"
            [
                'content' => 'Great strategies! We\'ve had success with content marketing too. Blog posts about industry pain points have been our best lead generator.',
                'post_title' => 'Growth Hacking Strategies for B2B SaaS',
                'author_email' => 'emma@example.com',
            ],

            // Comments for "MVP Development Timeline"
            [
                'content' => 'We went with React Native for our MVP. The cross-platform benefits really helped us launch faster.',
                'post_title' => 'MVP Development Timeline',
                'author_email' => 'alex@example.com',
            ],
            [
                'content' => 'Consider starting with a landing page to validate interest before full MVP development.',
                'post_title' => 'MVP Development Timeline',
                'author_email' => 'sarah@example.com',
            ],

            // Comments for "Legal Requirements for FinTech Startup"
            [
                'content' => 'Make sure to consult with a fintech-specialized lawyer. The regulations vary significantly by region and service type.',
                'post_title' => 'Legal Requirements for FinTech Startup',
                'author_email' => 'michael@example.com',
            ],
            [
                'content' => 'We can connect you with our legal team who helped us navigate the compliance landscape.',
                'post_title' => 'Legal Requirements for FinTech Startup',
                'author_email' => 'sarah@example.com',
            ],
        ];

        foreach ($comments as $comment) {
            $post = ForumPost::where('title', $comment['post_title'])->first();
            $author = User::where('email', $comment['author_email'])->first();
            
            if ($post && $author) {
                ForumComment::create([
                    'content' => $comment['content'],
                    'post_id' => $post->id,
                    'user_id' => $author->id,
                ]);
            }
        }
    }
} 