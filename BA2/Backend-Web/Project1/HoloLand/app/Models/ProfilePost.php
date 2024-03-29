<?php

namespace App\Models;

use App\Helper\Formatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfilePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_id',
        'profile_post_id',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function profilePost(): BelongsTo
    {
        return $this->belongsTo(ProfilePost::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ProfilePost::class);
    }

    public function owner(): User
    {
        $user = $this->user()->first();
        $user->populateFields();
        return $user;
    }

    public function owningProfile(): Profile|null
    {
        return $this->profile()->first();
    }

    public function owningProfilePost(): ProfilePost|null
    {
        return $this->profilePost()->first();
    }

    /**
     * @return ProfilePost[]
     */
    public function getReplies()
    {
        return $this->replies()->get();
    }

    public function content(): string
    {
        return Formatter::apply($this->content);
    }

    public static function getById(string $id): ProfilePost|null
    {
        return static::where('id', $id)->first();
    }

    public static function latestLogs()
    {
        return static::orderBy('created_at', 'desc')->take(100)->get();
    }

    /**
     * @return ProfilePost[]
     */
    public static function recentPosts()
    {
        return static::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * @return ProfilePost[]
     */
    public static function recentTopPosts()
    {
        return static::orderBy('created_at', 'desc')
            ->where('profile_post_id', null)
            ->limit(5)
            ->get();
    }
}
