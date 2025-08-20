<?php

namespace App\Modules\Master\Models;

use App\Modules\Profile\Models\Comment;
use App\Modules\Profile\Models\Follower;
use App\Modules\Profile\Models\Like;
use App\Modules\Profile\Models\Post;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'remember_token',
        'picture',
        'description',
        'email_verified_at',
        'socialnetworks',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function following()
    {
        return $this->hasMany(Follower::class, 'following_id');
    }

    public function follower()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }

    function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    function like(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'socialnetworks' => 'array',
        ];
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
