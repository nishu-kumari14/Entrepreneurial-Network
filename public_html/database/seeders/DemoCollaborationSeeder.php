<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoCollaborationSeeder extends Seeder
{
    public function run()
    {
        $projects = Project::all();
        $users = User::all();

        foreach ($projects as $project) {
            // Get 2-4 random users who are not the project owner
            $collaborators = $users
                ->where('id', '!=', $project->user_id)
                ->random(rand(2, 4));

            $project->collaborators()->attach($collaborators);
        }
    }
} 