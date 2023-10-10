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

    public string $email;
    public string $ip_address;
    public string $user_agent;
    public bool $success;

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
}
