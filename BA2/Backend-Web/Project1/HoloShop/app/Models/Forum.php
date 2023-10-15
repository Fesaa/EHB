<?php

namespace App\Models;

use App\Helper\Formatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_id',
    ];

    public function imageAsset(): Asset|null {
        return $this->imageID()->first();
    }

    public function subtitle() {
        return Formatter::apply($this->subtitle);
    }

    public function description() {
        return Formatter::apply($this->description);
    }

    public function image(): string {
        $default = env('DEFAULT_FORUM_IMAGE_URL', 'https://cdn-icons-png.flaticon.com/512/2815/2815428.png');
        $asset = $this->imageAsset();
        if ($asset == null) {
            return $default;
        }
        return $asset->getAsset() ?? $default;
    }

    public function imageID(): BelongsTo {
        return $this->belongsTo(Asset::class, 'image_id');
    }

    public function locks(): BelongsToMany {
        return $this->belongsToMany(Privilege::class, 'forum_locks', 'forum_id', 'privilege_id');
    }

    public function cloaks(): BelongsToMany {
        return $this->belongsToMany(Privilege::class, 'forum_cloaks', 'forum_id', 'privilege_id');
    }

    public function canSee(User|null $user): bool {
        $c = $this->cloaks()->count();
        if ($user == null || $c == 0) {
            return $c == 0;
        }

        foreach ($this->cloaks as $cloak) {
            if ($user->hasPrivilege($cloak->value)) {
                return true;
            }
        }
        return false;
    }

    public static function getVisibleForums(User|null $user) {
        if ($user == null) {
            return static::whereDoesntHave('cloaks')->get()->sortBy('created_at');
        }

        $forums = static::with('cloaks')->get()->sortBy('created_at');
        $visible = [];
        foreach ($forums as $forum) {
            if ($forum->canSee($user)) {
                $visible[] = $forum;
            }
        }
        return $visible;
    }

    public static function getForum(int $id): Forum|null {
        return static::where(["id" => $id])->first();
    }

    public function threads() {
        return $this->hasMany(Thread::class, 'forum_id');
    }

    /**
     * @return Thread|null
     */
    public function getLatestThread(): ?Thread
    {
        return $this->threads()->orderBy('created_at', 'desc')->first();
    }

    public function canEdit(User|null $user): bool {
        if ($user == null) {
            return false;
        }

        return $user->hasPrivilege(Privilege::privilegeValueOf("FORUM_EDIT"));
    }

    public function hasLock(string $name): bool {
        return $this->locks()->where(["name" => $name])->first() != null;
    }

    public function hasCloak(string $name): bool {
        return $this->cloaks()->where(["name" => $name])->first() != null;
    }

}
