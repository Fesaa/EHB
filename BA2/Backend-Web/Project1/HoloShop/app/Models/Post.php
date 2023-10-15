<?php

namespace App\Models;

use App\Helper\Formatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id',
        'content',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function content()
    {
        return Formatter::apply($this->content);
    }

    public function owner()
    {
        return $this->user()->first();
    }

    public function owningThread()
    {
        return $this->thread()->first();
    }
}
