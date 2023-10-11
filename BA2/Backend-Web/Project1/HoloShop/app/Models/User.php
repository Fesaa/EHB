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
        'privilege'
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

    public function hasPrivilege(int $privilege): bool {
        return ($this->privilege & $privilege) == $privilege;
    }

    public function isStaff(): bool {
        return $this->hasPrivilege(Privilege::getPrivilegeValue('STAFF'));
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


}