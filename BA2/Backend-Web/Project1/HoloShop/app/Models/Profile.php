<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pfp_asset_id',
        'banner_asset_id',
        'birthday',
        'bio',
        'pronouns',
        'location',
        'title',
    ];

    protected $casts = [
        'birthday' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pfpAssetID(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'pfp_asset_id');
    }

    public function bannerAssetID(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'banner_asset_id');
    }

    private function getProfilePictureAsset(): Asset|null
    {
        return $this->pfpAssetID()->first();
    }

    private function getBannerPictureAsset(): Asset|null
    {
        return $this->bannerAssetID()->first();
    }

    private function getUser(): User|null
    {
        return $this->user()->first();
    }

    public function profilePicture(): string {
        $default = env('DEFAULT_PFP_URL', 'https://forums.cubecraftcdn.com/xenforo/data/avatars/o/224/224741.jpg?1695386528');
        $asset = $this->getProfilePictureAsset();
        if ($asset == null) {
            return $default;
        }

        $url = $asset->getAsset();
        if ($url == null) {
            return $default;
        }
        return $url;
    }


    public function bannerPicture(): string {
        $default = env('DEFAULT_BANNER_URL', 'https://forums.cubecraftcdn.com/xenforo/data/profile_banners/l/224/224741.jpg?1665157964');
        $asset = $this->getBannerPictureAsset();
        if ($asset == null) {
            return $default;
        }

        $url = $asset->getAsset();
        if ($url == null) {
            return $default;
        }
        return $url;
    }


    public function isBirthday(): bool {
        $today = new DateTime();
        try {
            $birthday = new DateTime($this->birthday);
        } catch (\Exception $e) {
            return false;
        }
        return $today->format('d-m') == $birthday->format('d-m');
    }

    public function title(): string {
        if ($this->title != null) {
            return $this->title;
        }

        return $this->getUser()->getHighestRole()->title();
    }
}
