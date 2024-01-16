<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Privilege extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'value'
    ];


    // Change to cache later
    public static function privilegeValueOf(string $name): int {
        $privilege = Privilege::where(['name' => $name])->first();
        if ($privilege == null) {
            // Return value that will never match
            return -1;
        }
        return $privilege->value;
    }

    public function name(): string {
        $name = str_replace('_', ' ', $this->name);
        $name = strtolower($name);
        return ucwords($name);
    }

    public function forum_locks(): BelongsToMany {
        return $this->belongsToMany(Forum::class, 'forum_locks');
    }

    /**
     * @return Privilege[]
     */
    public static function getAllForumLocks()
    {
        return static::where('name', 'LIKE', 'FORUM_LOCK_%')->get();
    }

    /**
     * @return Privilege[]
     */
    public static function getAllForumCloaks()
    {
        return static::where('name', 'LIKE', 'FORUM_CLOAK_%')->get();
    }

    /**
     * @return Privilege[]
     */
    public static function getAllThreadLocks()
    {
        return static::where('name', 'LIKE', 'THREAD_LOCK_%')->get();
    }

    /**
     * @return Privilege[]
     */
    public static function getAllThreadCloaks()
    {
        return static::where('name', 'LIKE', 'THREAD_CLOAK_%')->get();
    }


}
