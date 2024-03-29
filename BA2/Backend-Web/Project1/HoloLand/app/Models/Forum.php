<?php

namespace App\Models;

use App\Helper\Formatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_id',
        'weight',
    ];

    public function form(): HasMany
    {
        return $this->HasMany(ThreadForm::class);
    }

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

    public function autoThreadLocks(): BelongsToMany {
        return $this->belongsToMany(Privilege::class, 'forums_auto_thread_locks', 'forum_id', 'privilege_id');
    }

    public function autoThreadCloaks(): BelongsToMany {
        return $this->belongsToMany(Privilege::class, 'forums_auto_thread_cloaks', 'forum_id', 'privilege_id');
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

    /**
     * @param User|null $user
     * @return Forum[]
     */
    public static function getVisibleForums(User|null $user) {
        if ($user == null) {
            return static::whereDoesntHave('cloaks')->get()->sortBy('created_at')->sortByDesc('weight');
        }

        $forums = static::with('cloaks')->get()->sortBy('created_at')->sortByDesc('weight');
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
     * @param User|null $user
     * @return Thread|null
     */
    public function getLatestThread(User|null $user): ?Thread
    {
        if ($user == null) {
            return $this->threads()->whereDoesntHave('cloaks')->orderBy('created_at', 'desc')->first();
        }

        /**
         * @var Thread|null $thread
         */
        $ids = [];
        do {
            $thread = $this->latestButNotWithID($ids);
            if ($thread != null && $thread->canSee($user)) {
                return $thread;
            }
            if ($thread != null) {
                $ids[] = $thread->id;
            }
        } while ($thread != null);

        return null;
    }

    private function latestButNotWithID(array $ids): Thread|null
    {
        return $this->threads()->whereNotIn('id', $ids)->orderBy('created_at', 'desc')->first();
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

    public function hasAutoThreadLock(string $name): bool {
        return $this->autoThreadLocks()->where(["name" => $name])->first() != null;
    }

    public function hasAutoThreadCloak(string $name): bool {
        return $this->autoThreadCloaks()->where(["name" => $name])->first() != null;
    }

    public function canPostOn(User|null $user): bool
    {
        if ($user == null) {
            return false;
        }

        if (!$this->canSee($user)) {
            return false;
        }

        $locks = $this->locks()->get();

        if ($locks->count() == 0) {
            return true;
        }

        foreach ($locks as $lock) {
            if ($user->hasPrivilege($lock->value)) {
                return true;
            }
        }
        return false;
    }

    public static function latestLogs()
    {
        return static::orderBy('created_at', 'desc')->take(100)->get();
    }

    public function hasForm(): bool
    {
        return $this->form()->first() != null;
    }

    /**
     * @return ThreadForm[]
     */
    public function getFormFields() {
        return $this->form()->orderBy('field_count')->get();
    }

}
