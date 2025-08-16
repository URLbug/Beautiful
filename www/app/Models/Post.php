<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'file',
        'user_id',
    ];

    function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function like(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}
