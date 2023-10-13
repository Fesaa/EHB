<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_id',
    ];

    public function getSubTitle() {
        // TODO: Add markdown support
        return $this->subtitle;
    }

    public function getDescription() {
        // TODO: Add markdown support
        return $this->description;
    }

    public function getImage(): string {
        $default = env('DEFAULT_FORUM_IMAGE_URL', 'https://cdn-icons-png.flaticon.com/512/2815/2815428.png');
        $asset = $this->imageID()->first();
        if ($asset == null) {
            return $default;
        }

        $url = $asset->getAsset();
        if ($url == null) {
            return $default;
        }
        return $url;
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
        if ($user == null) {
            return $this->cloaks->count() == 0;
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
            if ($forum->cloaks->count() == 0) {
                $visible[] = $forum;
                continue;
            }
            if ($forum->canSee($user)) {
                $visible[] = $forum;
            }
        }
        return $visible;
    }

}
