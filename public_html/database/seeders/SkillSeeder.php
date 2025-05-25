<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $skills = [
            'PHP',
            'Laravel',
            'JavaScript',
            'Vue.js',
            'React',
            'Node.js',
            'Python',
            'Django',
            'Ruby',
            'Ruby on Rails',
            'Java',
            'Spring Boot',
            'C#',
            '.NET',
            'SQL',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'Redis',
            'Docker',
            'AWS',
            'Azure',
            'Google Cloud',
            'DevOps',
            'CI/CD',
            'Git',
            'HTML',
            'CSS',
            'Sass',
            'UI/UX Design',
            'Mobile Development',
            'iOS',
            'Android',
            'Flutter',
            'React Native',
            'Machine Learning',
            'AI',
            'Data Science',
            'Blockchain',
            'Smart Contracts',
            'Project Management',
            'Agile',
            'Scrum',
            'Marketing',
            'SEO',
            'Content Writing',
            'Business Development',
            'Sales',
            'Customer Service',
            'Technical Writing'
        ];

        foreach ($skills as $skillName) {
            Skill::firstOrCreate(
                ['name' => $skillName],
                ['slug' => Str::slug($skillName)]
            );
        }
    }
} 