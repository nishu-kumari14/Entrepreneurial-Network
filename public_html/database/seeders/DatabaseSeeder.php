<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Skill;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ForumCategorySeeder::class,
            DemoUserSeeder::class,
            SkillSeeder::class,
            DemoMessageSeeder::class,
            DemoActivitySeeder::class,
            DemoNotificationSeeder::class,
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'System Administrator',
            'location' => 'San Francisco, CA',
            'interests' => ['Technology', 'Innovation']
        ]);

        // Add admin skills
        $adminSkills = ['Project Management', 'Leadership'];
        foreach ($adminSkills as $skillName) {
            $skill = Skill::firstOrCreate(['name' => $skillName]);
            $admin->skills()->attach($skill->id, [
                'level' => 'expert',
                'experience_years' => 5
            ]);
        }
    }
}
