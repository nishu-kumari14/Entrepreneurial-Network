<?php

namespace Tests\Feature;

use App\Models\Collaboration;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollaborationTest extends TestCase
{
    use RefreshDatabase;

    public function test_collaboration_can_be_created()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        
        $collaboration = Collaboration::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
        
        $this->assertInstanceOf(Collaboration::class, $collaboration);
        $this->assertEquals($project->id, $collaboration->project_id);
        $this->assertEquals($user->id, $collaboration->user_id);
    }

    public function test_collaboration_has_project()
    {
        $collaboration = Collaboration::factory()->create();
        
        $this->assertInstanceOf(Project::class, $collaboration->project);
        $this->assertEquals($collaboration->project_id, $collaboration->project->id);
    }

    public function test_collaboration_has_user()
    {
        $collaboration = Collaboration::factory()->create();
        
        $this->assertInstanceOf(User::class, $collaboration->user);
        $this->assertEquals($collaboration->user_id, $collaboration->user->id);
    }

    public function test_collaboration_can_be_filtered_by_status()
    {
        Collaboration::factory(2)->pending()->create();
        Collaboration::factory(3)->accepted()->create();
        Collaboration::factory(1)->rejected()->create();
        
        $this->assertCount(2, Collaboration::pending()->get());
        $this->assertCount(3, Collaboration::accepted()->get());
        $this->assertCount(1, Collaboration::rejected()->get());
    }

    public function test_collaboration_status_check_methods()
    {
        $pending = Collaboration::factory()->pending()->create();
        $accepted = Collaboration::factory()->accepted()->create();
        $rejected = Collaboration::factory()->rejected()->create();
        
        $this->assertTrue($pending->isPending());
        $this->assertFalse($pending->isAccepted());
        $this->assertFalse($pending->isRejected());
        
        $this->assertFalse($accepted->isPending());
        $this->assertTrue($accepted->isAccepted());
        $this->assertFalse($accepted->isRejected());
        
        $this->assertFalse($rejected->isPending());
        $this->assertFalse($rejected->isAccepted());
        $this->assertTrue($rejected->isRejected());
    }

    public function test_collaboration_status_badge_classes()
    {
        $pending = Collaboration::factory()->pending()->create();
        $accepted = Collaboration::factory()->accepted()->create();
        $rejected = Collaboration::factory()->rejected()->create();
        
        $this->assertEquals('bg-yellow-100 text-yellow-800', $pending->getStatusBadgeClass());
        $this->assertEquals('bg-green-100 text-green-800', $accepted->getStatusBadgeClass());
        $this->assertEquals('bg-red-100 text-red-800', $rejected->getStatusBadgeClass());
    }

    public function test_cannot_create_duplicate_pending_requests()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        
        Collaboration::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Collaboration::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
    }
} 