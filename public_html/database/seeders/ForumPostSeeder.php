<?php

namespace Database\Seeders;

use App\Models\ForumPost;
use App\Models\ForumCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ForumPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Building a Sustainable Tech Startup in 2024',
                'content' => 'As we navigate through 2024, sustainability has become a crucial factor in tech startups. I\'d like to share my experience in building a green tech company and discuss strategies for reducing environmental impact while maintaining profitability. What sustainable practices have you implemented in your startup?',
                'category' => 'Tech Innovation'
            ],
            [
                'title' => 'Effective Growth Hacking Strategies for SaaS',
                'content' => 'In the competitive SaaS market, growth hacking has become essential. I\'ve found success with a combination of content marketing, referral programs, and strategic partnerships. Let\'s discuss what growth strategies have worked for your SaaS business and share insights on measuring success.',
                'category' => 'Marketing & Growth'
            ],
            [
                'title' => 'Navigating Series A Funding in Current Market',
                'content' => 'The funding landscape has changed significantly in recent months. I\'m preparing for Series A and would love to hear from founders who\'ve recently gone through this process. What metrics are investors focusing on now? How has your pitch strategy evolved?',
                'category' => 'Funding & Investment'
            ],
            [
                'title' => 'Product-Market Fit: Signs and Strategies',
                'content' => 'Achieving product-market fit is often described as a "feeling," but there are concrete metrics we can track. I\'ve developed a framework for measuring PMF that I\'d like to share and discuss. What indicators do you use to determine if you\'ve achieved PMF?',
                'category' => 'Product Development'
            ],
            [
                'title' => 'Building a Remote-First Company Culture',
                'content' => 'As we transition to a remote-first model, I\'m interested in learning how other founders maintain company culture and team cohesion. What tools and practices have you found effective for remote team building and communication?',
                'category' => 'Entrepreneurial Mindset'
            ],
            [
                'title' => 'Competitive Analysis Framework',
                'content' => 'I\'ve developed a comprehensive framework for competitive analysis that goes beyond basic SWOT. It includes market positioning, feature comparison, and growth trajectory analysis. Would love to get feedback and hear how others approach competitive analysis.',
                'category' => 'Business Strategy'
            ],
            [
                'title' => 'From Idea to MVP: A Practical Guide',
                'content' => 'I\'m documenting my journey from concept to MVP and would like to share the key lessons learned. This includes validating ideas, building the right team, and creating an effective MVP. What was your experience in this phase?',
                'category' => 'Startup Founders'
            ]
        ];

        foreach ($posts as $post) {
            $category = ForumCategory::where('name', $post['category'])->first();
            $user = User::inRandomOrder()->first();

            ForumPost::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'content' => $post['content'],
                'views' => rand(50, 500)
            ]);
        }
    }
} 