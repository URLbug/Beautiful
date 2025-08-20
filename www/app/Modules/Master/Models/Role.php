<?php

namespace App\Modules\Master\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'slug',
        'permissions',
    ];

    public function users(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'role_id', 'id');
    }
}
