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

    public function owner(): User|null
    {
        $user = $this->user()->first();
        $user->populateFields();
        return $user;
    }

    public function owningThread()
    {
        return $this->thread()->first();
    }

    public function canEdit(User|null $user): bool {
        if ($user == null) {
            return false;
        }

        if ($user->id == $this->user_id) {
            return true;
        }


        return $user->hasPrivilege(Privilege::privilegeValueOf("POST_EDIT"));
    }

    public static function getPost($id)
    {
        return Post::where('id', $id)->first();
    }
}
