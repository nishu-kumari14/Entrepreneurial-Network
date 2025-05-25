<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class DemoProjectSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'title' => 'AI-Powered Education Platform',
                'description' => 'Building an innovative education platform that uses artificial intelligence to create personalized learning paths for students.',
                'status' => 'active',
                'email' => 'alex@example.com',
                'skills' => ['AI', 'Machine Learning', 'Python', 'React', 'Node.js']
            ],
            [
                'title' => 'Sustainable E-commerce Solution',
                'description' => 'Developing an eco-friendly e-commerce platform that focuses on sustainable products and carbon-neutral delivery.',
                'status' => 'active',
                'email' => 'sarah@example.com',
                'skills' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Docker']
            ],
            [
                'title' => 'HealthTech Mobile App',
                'description' => 'Creating a mobile application for tracking personal health metrics and connecting with healthcare providers.',
                'status' => 'active',
                'email' => 'michael@example.com',
                'skills' => ['React Native', 'Node.js', 'MongoDB', 'AWS']
            ],
            [
                'title' => 'Smart Home Automation System',
                'description' => 'Developing an IoT-based home automation system with voice control and energy optimization features.',
                'status' => 'active',
                'email' => 'emma@example.com',
                'skills' => ['Python', 'C#', 'IoT', 'Machine Learning']
            ],
            [
                'title' => 'Blockchain-based Supply Chain',
                'description' => 'Building a transparent supply chain management system using blockchain technology.',
                'status' => 'active',
                'email' => 'david@example.com',
                'skills' => ['Blockchain', 'Smart Contracts', 'JavaScript', 'Node.js']
            ]
        ];

        foreach ($projects as $projectData) {
            $skills = $projectData['skills'];
            unset($projectData['skills']);
            
            $user = User::where('email', $projectData['email'])->first();
            unset($projectData['email']);
            
            if ($user) {
                $project = Project::create(array_merge($projectData, ['user_id' => $user->id]));
                
                // Attach skills
                $skillIds = Skill::whereIn('name', $skills)->pluck('id');
                $project->skills()->attach($skillIds);
            }
        }
    }
} 