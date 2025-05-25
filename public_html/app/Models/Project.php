<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Notifications\ProjectUpdateNotification;
use Illuminate\Support\Facades\Notification;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
        'skills_required',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'skills_required' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    protected $withCount = ['collaborators'];

    /**
     * Get the owner of the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the collaborators of the project.
     */
    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_collaborators')
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    /**
     * Get the collaboration requests for the project.
     */
    public function collaborationRequests(): HasMany
    {
        return $this->hasMany(Collaboration::class)
            ->where('status', 'pending');
    }

    /**
     * Get all collaborations for the project.
     */
    public function collaborations(): HasMany
    {
        return $this->hasMany(Collaboration::class);
    }

    /**
     * Get the messages for the project.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the skills required for the project.
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'project_skills')
            ->withPivot('required_level')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active projects.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include completed projects.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include projects on hold.
     */
    public function scopeOnHold($query)
    {
        return $query->where('status', 'on_hold');
    }

    /**
     * Scope a query to only include projects that require specific skills.
     */
    public function scopeWithSkills($query, array $skillIds)
    {
        return $query->whereHas('skills', function($q) use ($skillIds) {
            $q->whereIn('skills.id', $skillIds);
        });
    }

    /**
     * Check if a user is a collaborator on the project.
     */
    public function isCollaborator(User $user): bool
    {
        return $this->collaborators()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Check if a user has a pending collaboration request.
     */
    public function hasPendingRequest(User $user): bool
    {
        return $this->collaborationRequests()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Get the status badge class based on the project status.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'completed' => 'bg-blue-100 text-blue-800',
            'on_hold' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function notifyCollaborators(string $message, string $type = 'info'): void
    {
        $collaborators = $this->collaborations()->with('user')->get()->pluck('user');
        $collaborators->push($this->user);

        foreach ($collaborators as $user) {
            $this->notifyUser($user, $message, $type);
        }
    }

    public function notifyUser(User $user, string $message, string $type = 'info'): void
    {
        $user->notify(new ProjectUpdateNotification($this, $message, $type));
    }

    public function documents(): HasMany
    {
        return $this->hasMany(DocumentCollaboration::class);
    }

    public function chatRooms(): HasMany
    {
        return $this->hasMany(ChatRoom::class);
    }

    public function codeReviews(): HasMany
    {
        return $this->hasMany(CodeReview::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
