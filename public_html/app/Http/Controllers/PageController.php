<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'title' => 'About Us',
            'description' => 'Learn more about EN Connects and our mission to connect entrepreneurs worldwide.',
            'features' => [
                [
                    'title' => 'Global Network',
                    'description' => 'Connect with entrepreneurs from around the world and expand your professional network.',
                    'icon' => 'globe'
                ],
                [
                    'title' => 'Knowledge Sharing',
                    'description' => 'Share your expertise and learn from other entrepreneurs in our community.',
                    'icon' => 'lightbulb'
                ],
                [
                    'title' => 'Collaboration',
                    'description' => 'Find potential partners and collaborators for your projects and ventures.',
                    'icon' => 'users'
                ]
            ],
            'team' => [
                [
                    'name' => 'Founder & CEO',
                    'role' => 'Leadership',
                    'bio' => 'Passionate about connecting entrepreneurs and fostering innovation.'
                ],
                [
                    'name' => 'Community Manager',
                    'role' => 'Community',
                    'bio' => 'Dedicated to building and nurturing our global entrepreneur community.'
                ]
            ]
        ]);
    }

    public function network()
    {
        return view('pages.network', [
            'title' => 'Our Network',
            'description' => 'Join our growing network of entrepreneurs and professionals.',
            'stats' => [
                'members' => 10000,
                'countries' => 50,
                'projects' => 5000,
                'connections' => 25000
            ],
            'benefits' => [
                [
                    'title' => 'Global Reach',
                    'description' => 'Connect with entrepreneurs from over 50 countries worldwide.',
                    'icon' => 'globe'
                ],
                [
                    'title' => 'Industry Diversity',
                    'description' => 'Network with professionals across various industries and sectors.',
                    'icon' => 'briefcase'
                ],
                [
                    'title' => 'Expertise Sharing',
                    'description' => 'Access a wealth of knowledge and expertise from experienced entrepreneurs.',
                    'icon' => 'book'
                ]
            ]
        ]);
    }
} 