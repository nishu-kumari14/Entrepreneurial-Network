<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'location',
        'interests',
        'email_verified_at',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'interests' => 'array',
        ];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function collaboratingProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_collaborators')
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function forumPosts(): HasMany
    {
        return $this->hasMany(ForumPost::class);
    }

    public function forumComments(): HasMany
    {
        return $this->hasMany(ForumComment::class);
    }

    public function forumLikes(): HasMany
    {
        return $this->hasMany(ForumLike::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'user_skills')
            ->withPivot('level', 'experience_years')
            ->withTimestamps();
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function collaborations(): HasMany
    {
        return $this->hasMany(Collaboration::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEntrepreneur(): bool
    {
        return $this->role === 'entrepreneur';
    }

    public function getUnreadMessagesCount(): int
    {
        return $this->receivedMessages()->whereNull('read_at')->count();
    }

    public function getPendingCollaborationsCount(): int
    {
        return $this->collaborations()->where('status', 'pending')->count();
    }

    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/profile_pictures/' . $this->profile_picture);
        }
        
        // Get first and last name initials
        $nameParts = explode(' ', $this->name);
        $initials = '';
        if (count($nameParts) > 1) {
            $initials = strtoupper($nameParts[0][0] . $nameParts[count($nameParts) - 1][0]);
        } else {
            $initials = strtoupper(substr($this->name, 0, 2));
        }
        
        // Generate a consistent color based on the name
        $colors = ['#7F9CF5', '#B794F4', '#F687B3', '#F6AD55', '#68D391', '#4FD1C5'];
        $colorIndex = ord($initials[0]) % count($colors);
        $color = $colors[$colorIndex];
        
        // Create SVG with proper encoding
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">';
        $svg .= '<rect width="100" height="100" fill="' . $color . '" rx="50" ry="50"/>';
        $svg .= '<text x="50%" y="50%" font-family="Arial" font-size="40" fill="white" text-anchor="middle" dominant-baseline="middle">' . $initials . '</text>';
        $svg .= '</svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')
            ->whereNull('read_at');
    }
}
