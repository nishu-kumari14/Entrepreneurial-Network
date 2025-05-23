<?php

namespace Database\Seeders;

use App\Models\ForumPost;
use App\Models\User;
use App\Models\ForumCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoForumPostSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'title' => 'Looking for Co-founder for AI Startup',
                'content' => 'I\'m building an AI-powered platform for personalized education and looking for a technical co-founder with experience in machine learning and web development. The platform will use adaptive learning algorithms to create personalized learning paths for students.',
                'category_id' => 1, // Startup Ideas
                'author_email' => 'alex@example.com',
            ],
            [
                'title' => 'Best Practices for Seed Funding',
                'content' => 'I\'m preparing to raise seed funding for my SaaS startup. Looking for advice on valuation, pitch deck structure, and investor outreach strategies. Would love to hear from experienced founders who have successfully raised seed rounds.',
                'category_id' => 2, // Funding & Investment
                'author_email' => 'sarah@example.com',
            ],
            [
                'title' => 'Growth Hacking Strategies for B2B SaaS',
                'content' => 'Sharing some successful growth hacking strategies we\'ve implemented for our B2B SaaS product. Includes content marketing, referral programs, and strategic partnerships. Would love to hear other founders\' experiences and strategies.',
                'category_id' => 3, // Marketing & Growth
                'author_email' => 'michael@example.com',
            ],
            [
                'title' => 'MVP Development Timeline',
                'content' => 'Planning to build an MVP for our mobile app. Looking for advice on realistic timelines, essential features, and development approaches. We\'re considering React Native vs. Flutter for cross-platform development.',
                'category_id' => 4, // Product Development
                'author_email' => 'emma@example.com',
            ],
            [
                'title' => 'Legal Requirements for FinTech Startup',
                'content' => 'Starting a FinTech company and need guidance on legal requirements, compliance, and necessary licenses. Specifically interested in payment processing and data security regulations.',
                'category_id' => 5, // Legal & Compliance
                'author_email' => 'david@example.com',
            ],
        ];

        foreach ($posts as $post) {
            $author_email = $post['author_email'];
            unset($post['author_email']);
            
            $author = User::where('email', $author_email)->first();
            if ($author) {
                $post['slug'] = Str::slug($post['title']);
                ForumPost::create(array_merge($post, ['user_id' => $author->id]));
            }
        }
    }
} 