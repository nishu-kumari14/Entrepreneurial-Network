<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentCollaboration extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'content',
        'type',
        'current_editors',
        'edit_history',
    ];

    protected $casts = [
        'current_editors' => 'array',
        'edit_history' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function addEditor(User $user): void
    {
        $editors = $this->current_editors ?? [];
        if (!in_array($user->id, $editors)) {
            $editors[] = $user->id;
            $this->current_editors = $editors;
            $this->save();
        }
    }

    public function removeEditor(User $user): void
    {
        $editors = $this->current_editors ?? [];
        $this->current_editors = array_values(array_diff($editors, [$user->id]));
        $this->save();
    }

    public function addEditHistory(User $user, string $action): void
    {
        $history = $this->edit_history ?? [];
        $history[] = [
            'user_id' => $user->id,
            'action' => $action,
            'timestamp' => now()->toISOString(),
        ];
        $this->edit_history = $history;
        $this->save();
    }
} 