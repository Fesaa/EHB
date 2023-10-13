<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_users');
    }

    public function hasRole(string $name): bool
    {
        $name = strtoupper($name);
        $roles = $this->roles()->get();
        foreach ($roles as $role) {
            if (strtoupper($role->name) == $name)
                return true;
        }
        return false;
    }

    public function hasPrivilege(int $privilege): bool {
        // Should add caches later for performance
        $roles = $this->roles()->get();
        return $this->hasPriv($roles, $privilege);
    }

    private function hasPriv($roles, int $privilege): bool {
        foreach ($roles as $role) {
            if ($role->hasPrivilege($privilege))
                return true;
        }
        return false;
    }

    public function allPrivileges(): array {
        $all = Privilege::all()->sortBy('id');
        $privileges = [];
        $roles = $this->roles()->get();
        foreach ($all as $privilege) {
            if ($this->hasPriv($roles, $privilege->value)) {
                $privileges[] = $privilege;
            }
        }
        return $privileges;
    }

    public function isStaff(): bool {
        return $this->hasRole("STAFF");
    }

    public function isAuth(): bool {
        $user = auth()->user();
        if ($user == null)
            return false;
        return $this->id == $user->id;
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function getProfile(): Profile {
        $profile = $this->profile()->first();
        if ($profile == null) {
            $profile = new Profile();
            $profile->birthday = $this->created_at;
            $this->profile()->save($profile);
        }
        return $this->profile()->first();
    }

    public function getHighestRole(): Role {
        return $this->roles()->orderBy('weight', 'desc')->first();
    }

    public function getColour(): string {
        return $this->getHighestRole()->getColour() ?? env("DEFAULT_ROLE_COLOUR", "#808080");
    }

    public function canEdit(User $other): bool
    {
        if ($this->id == $other->id) {
            return true;
        }

        if (!$this->hasPrivilege(Privilege::getPrivilegeValue('MEMBERS_EDIT_PROFILE'))) {
            return false;
        }

        if ($this->getHighestRole()->outRanks($other->getHighestRole())) {
            return true;
        }

        return false;
    }


    public function getColouredName(): string {
        $colour = $this->getColour();
        return '<div style="color:' . $colour . '; font-weight: bolder;">' . $this->name . '</div>';
    }

}
