<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'user_id',
        'post_id'
    ];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function like(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    
    function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
