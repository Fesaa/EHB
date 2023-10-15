<?php

namespace App\Models;

use App\Helper\Formatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'user_id',
        'banner_id',
        'title',
        'content',
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function banner()
    {
        return $this->belongsTo(Asset::class, 'banner_id');
    }

    public function locks()
    {
        return $this->belongsToMany(Privilege::class, 'thread_locks', 'thread_id', 'privilege_id');
    }

    public function cloaks()
    {
        return $this->belongsToMany(Privilege::class, 'thread_cloaks', 'thread_id', 'privilege_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'thread_id');
    }

    public function content()
    {
        return Formatter::apply($this->content);
    }

    public function title()
    {
        return Formatter::applyTitle($this->title);
    }

    /**
     * @return Post[]
     */
    public function getReplies()
    {
        return $this->posts()->get();
    }

    public function canSee(User|null $user)
    {
        $c = $this->locks->count();
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

    // TODO: Order on threads with latest posts, rater than creation date. This is a bit more complicated,
    // but should be possible with a join on the posts table. If only I could raw sql in eloquent...
    public static function getVisibleThreads(User|null $user, int $id) {
        if ($user == null) {
            return static::whereDoesntHave('cloaks')->where(['forum_id' => $id])->get()->sortBy('updated_at');
        }

        $threads = static::with('cloaks')->where(['forum_id' => $id])->get()->sortBy('updated_at');
        $visible = [];
        foreach ($threads as $thread) {
            if ($thread->canSee($user)) {
                $visible[] = $thread;
            }
        }
        return $visible;
    }

    /**
     * @param int $id
     * @return Thread|null
     */
    public static function getThread(int $id) {
        return static::with('cloaks')->where(['id' => $id])->first();
    }

    // TODO: Check functionally after posts are implemented
    public function getLatestPost()
    {
        return array();
        return $this->posts()->orderBy('created_at', 'desc')->first();
    }

    public function owner(): User
    {
        return $this->user()->first();
    }

    public function getBannerImage(): string {
        $default = env('DEFAULT_THREAD_BANNER', 'https://static.vecteezy.com/system/resources/previews/027/775/631/non_2x/sunset-in-the-field-cute-kawaii-lo-fi-background-fluffy-clouds-park-2d-cartoon-landscape-illustration-lofi-aesthetic-wallpaper-desktop-japanese-anime-scenery-dreamy-vibes-vector.jpg');
        $asset = $this->banner()->first();
        if ($asset == null) {
            return $default;
        }
        return $asset->getAsset();
    }

    public function canEdit(User|null $user): bool {
        if ($user == null) {
            return false;
        }

        if ($user->id == $this->user_id) {
            return true;
        }


        return $user->hasPrivilege(Privilege::privilegeValueOf("THREAD_EDIT"));
    }

    public function hasLock(string $name): bool {
        return $this->locks()->where(["name" => $name])->first() != null;
    }

    public function hasCloak(string $name): bool {
        return $this->cloaks()->where(["name" => $name])->first() != null;
    }
}
