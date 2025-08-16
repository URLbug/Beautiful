<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment_id',
    ];

    function post(): BelongsTo 
    {
        return $this->belongsTo(Post::class);
    }

    function comment(): BelongsTo 
    {
        return $this->belongsTo(Comment::class);
    }
    
    function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

}
