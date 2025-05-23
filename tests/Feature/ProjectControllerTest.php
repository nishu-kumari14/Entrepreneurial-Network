<?php

namespace Tests\Feature;

use App\Models\Collaboration;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_projects()
    {
        $user = User::factory()->create();
        $projects = Project::factory(3)->create(['owner_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('projects.index'));

        $response->assertStatus(200)
            ->assertViewIs('projects.index')
            ->assertViewHas('projects');
    }

    public function test_create_returns_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('projects.create'));

        $response->assertStatus(200)
            ->assertViewIs('projects.form');
    }

    public function test_store_creates_project()
    {
        $user = User::factory()->create();
        $projectData = [
            'title' => 'Test Project',
            'description' => 'Test Description',
            'skills_required' => ['PHP', 'Laravel'],
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
        ];

        $response = $this->actingAs($user)
            ->post(route('projects.store'), $projectData);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'owner_id' => $user->id,
        ]);
    }

    public function test_show_displays_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('projects.show', $project));

        $response->assertStatus(200)
            ->assertViewIs('projects.show')
            ->assertViewHas('project');
    }

    public function test_edit_returns_form()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('projects.edit', $project));

        $response->assertStatus(200)
            ->assertViewIs('projects.form')
            ->assertViewHas('project');
    }

    public function test_update_modifies_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);
        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'skills_required' => ['JavaScript', 'React'],
            'status' => 'completed',
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
        ];

        $response = $this->actingAs($user)
            ->put(route('projects.update', $project), $updateData);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_destroy_deletes_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete(route('projects.destroy', $project));

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSoftDeleted('projects', [
            'id' => $project->id,
        ]);
    }

    public function test_collaborate_creates_request()
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $owner->id]);

        $response = $this->actingAs($user)
            ->post(route('projects.collaborate', $project));

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('collaborations', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }

    public function test_manage_collaboration_handles_requests()
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $owner->id]);
        $collaboration = Collaboration::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($owner)
            ->post(route('projects.manage-collaboration', $project), [
                'user_id' => $user->id,
                'action' => 'accept',
            ]);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('collaborations', [
            'id' => $collaboration->id,
            'status' => 'accepted',
        ]);

        $this->assertDatabaseHas('project_collaborators', [
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);
    }
} 