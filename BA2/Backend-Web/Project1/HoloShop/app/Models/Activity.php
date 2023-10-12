<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function onlineInLast($minutes)
    {
        return static::
            select('user_id', DB::raw('MAX(created_at) as last_seen'))
            ->where('created_at', '>', Carbon::now()->subMinutes($minutes))
            ->groupBy('user_id')
            ->get();
    }

    public static function staffOnlineInLast($minutes) {
        $activities = static::onlineInLast($minutes);

        $staff = [];
        foreach ($activities as $activity) {
            if ($activity->user()->first()->isStaff()) {
                $staff[] = $activity;
            }
        }
        return $staff;
    }

    public function getName() {
        $user = $this->user()->first();
        if ($user) {
            return $user->getColouredName();
        }
        return 'Unknown';
    }
}
