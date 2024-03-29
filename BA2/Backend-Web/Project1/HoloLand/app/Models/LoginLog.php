<?php

namespace App\Models;

use App\Interface\ILog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class LoginLog extends Model implements ILog
{
    use HasFactory;

    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'success'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedMessage(): string
    {
        return sprintf(
            "Login attempt by %s from %s using %s was %s",
            $this->email,
            $this->ip_address,
            $this->user_agent,
            $this->success ? "successful" : "unsuccessful"
        );
    }

    /**
     * @return LoginLog[]
     */
    public static function latestLogs()
    {
        return static::orderBy('created_at', 'desc')
            ->take(100)
            ->get();
    }

}
