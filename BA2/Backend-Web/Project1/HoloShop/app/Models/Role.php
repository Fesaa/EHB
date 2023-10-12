<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'privilege',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users');
    }

    public function hasPrivilege(int $privilege): bool {
        return ($this->privilege & $privilege) == $privilege;
    }
}
