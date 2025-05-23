<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
} 