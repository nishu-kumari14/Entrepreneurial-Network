<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CodeReview extends Model
{
    protected $fillable = [
        'project_id',
        'author_id',
        'title',
        'description',
        'status',
        'branch_name',
        'files_changed',
    ];

    protected $casts = [
        'files_changed' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CodeReviewComment::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(CodeReviewReaction::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isInReview(): bool
    {
        return $this->status === 'in_review';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function approve(User $user): void
    {
        $this->reactions()->updateOrCreate(
            ['user_id' => $user->id],
            ['reaction' => 'approve']
        );
        $this->updateStatus();
    }

    public function requestChanges(User $user): void
    {
        $this->reactions()->updateOrCreate(
            ['user_id' => $user->id],
            ['reaction' => 'request_changes']
        );
        $this->updateStatus();
    }

    private function updateStatus(): void
    {
        $reactions = $this->reactions()->get();
        $approvals = $reactions->where('reaction', 'approve')->count();
        $changes = $reactions->where('reaction', 'request_changes')->count();

        if ($changes > 0) {
            $this->status = 'in_review';
        } elseif ($approvals >= 2) { // Requiring at least 2 approvals
            $this->status = 'approved';
        }

        $this->save();
    }
} 