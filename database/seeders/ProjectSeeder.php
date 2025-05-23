<?php

namespace Database\Seeders;

use App\Models\Collaboration;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 users
        $users = User::factory(5)->create();

        // Create 10 projects with random owners
        $projects = Project::factory(10)
            ->create([
                'owner_id' => fn() => $users->random()->id
            ]);

        // For each project, create some collaboration requests
        $projects->each(function ($project) use ($users) {
            // Get users who are not the project owner
            $potentialCollaborators = $users->where('id', '!=', $project->owner_id);

            // Create 2-4 collaboration requests per project
            $numRequests = rand(2, 4);
            $potentialCollaborators->random($numRequests)->each(function ($user) use ($project) {
                Collaboration::factory()
                    ->create([
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'status' => 'pending'
                    ]);
            });

            // Accept some collaboration requests
            $project->collaborationRequests()
                ->take(rand(1, 2))
                ->get()
                ->each(function ($request) use ($project) {
                    $request->update(['status' => 'accepted']);
                    $project->collaborators()->attach($request->user_id);
                });
        });
    }
} 