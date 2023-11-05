<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'type',
        'label',
        'name',
        'placeholder',
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }
}
