<?php

namespace Tests\Feature;

use App\Models\Collaboration;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_be_created()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        $this->assertInstanceOf(Project::class, $project);
        $this->assertEquals($user->id, $project->owner_id);
    }

    public function test_project_has_owner()
    {
        $project = Project::factory()->create();
        
        $this->assertInstanceOf(User::class, $project->owner);
        $this->assertEquals($project->owner_id, $project->owner->id);
    }

    public function test_project_can_have_collaborators()
    {
        $project = Project::factory()->create();
        $collaborators = User::factory(3)->create();
        
        $project->collaborators()->attach($collaborators->pluck('id'));
        
        $this->assertCount(3, $project->collaborators);
        $this->assertTrue($project->collaborators->contains($collaborators->first()));
    }

    public function test_project_can_have_collaboration_requests()
    {
        $project = Project::factory()->create();
        $users = User::factory(2)->create();
        
        Collaboration::factory(2)->create([
            'project_id' => $project->id,
            'user_id' => fn() => $users->random()->id,
            'status' => 'pending'
        ]);
        
        $this->assertCount(2, $project->collaborationRequests);
        $this->assertEquals('pending', $project->collaborationRequests->first()->status);
    }

    public function test_project_can_check_if_user_is_collaborator()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        
        $project->collaborators()->attach($user->id);
        
        $this->assertTrue($project->isCollaborator($user));
    }

    public function test_project_can_check_if_user_has_pending_request()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        
        Collaboration::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
        
        $this->assertTrue($project->hasPendingRequest($user));
    }

    public function test_project_can_be_filtered_by_status()
    {
        Project::factory(2)->active()->create();
        Project::factory(3)->completed()->create();
        Project::factory(1)->onHold()->create();
        
        $this->assertCount(2, Project::active()->get());
        $this->assertCount(3, Project::completed()->get());
        $this->assertCount(1, Project::onHold()->get());
    }

    public function test_project_can_be_filtered_by_skills()
    {
        $project1 = Project::factory()->create(['skills_required' => ['PHP', 'Laravel']]);
        $project2 = Project::factory()->create(['skills_required' => ['JavaScript', 'React']]);
        
        $phpProjects = Project::withSkills(['PHP'])->get();
        $this->assertCount(1, $phpProjects);
        $this->assertEquals($project1->id, $phpProjects->first()->id);
    }
} 