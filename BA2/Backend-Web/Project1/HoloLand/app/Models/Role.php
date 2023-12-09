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
        'title',
        'colour',
        'weight',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users');
    }

    public function hasPrivilege(int $privilege): bool {
        return ($this->privilege & $privilege) == $privilege;
    }
    public function filter($privileges): array {
        $filtered = [];
        foreach ($privileges as $privilege) {
            if ($this->hasPrivilege($privilege->value)) {
                $filtered[] = $privilege;
            }
        }
        return $filtered;
    }

    public function outRanks(Role $role): bool {
        return $this->weight > $role->weight;
    }

    public function title(): string {
        return $this->title ?? $this->name;
    }

    public function colour(): string {
        return $this->colour ?? env("DEFAULT_ROLE_COLOUR", "#808080");
    }

    public function name(): string {
        $name = str_replace('_', ' ', $this->name);
        $name = strtolower($name);
        return ucwords($name);
    }
}
