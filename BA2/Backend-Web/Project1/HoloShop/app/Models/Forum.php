<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_id',
    ];

    public function imageID(): BelongsTo {
        return $this->belongsTo(Asset::class, 'image_id');
    }

    public function locks(): BelongsToMany {
        return $this->belongsToMany(Privilege::class, 'forum_locks');
    }
}
