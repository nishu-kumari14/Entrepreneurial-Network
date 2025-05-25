<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Startup Founders',
                'description' => 'Connect with fellow startup founders, share experiences, and discuss challenges in building and scaling your business.'
            ],
            [
                'name' => 'Tech Innovation',
                'description' => 'Discuss the latest technological advancements, AI, blockchain, and other emerging technologies shaping the future of business.'
            ],
            [
                'name' => 'Business Strategy',
                'description' => 'Share and learn about business strategies, market analysis, competitive positioning, and growth tactics.'
            ],
            [
                'name' => 'Funding & Investment',
                'description' => 'Connect with investors, discuss funding strategies, and learn about different investment opportunities and venture capital.'
            ],
            [
                'name' => 'Marketing & Growth',
                'description' => 'Exchange ideas about digital marketing, growth hacking, customer acquisition, and brand building strategies.'
            ],
            [
                'name' => 'Product Development',
                'description' => 'Discuss product management, development methodologies, user experience, and product-market fit.'
            ],
            [
                'name' => 'Entrepreneurial Mindset',
                'description' => 'Share personal growth stories, discuss work-life balance, and support each other in the entrepreneurial journey.'
            ]
        ];

        foreach ($categories as $category) {
            ForumCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description']
            ]);
        }
    }
} 