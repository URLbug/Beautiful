<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Orchid\Platform\Models\User as OrchidUser;

class User extends OrchidUser implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'remember_token',
        'picture',
        'description',
        'permissions',
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
}
