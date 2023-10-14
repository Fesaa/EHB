<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'data'
    ];


    public function getAsset(): string|null {
        if ($this->url != null) {
            return $this->url;
        }

        if ($this->data == null) {
            return null;
        }

        return 'data:image/png;base64,' . $this->data;
    }

    public static function getAssetFromID(int $id): string|null
    {
        $asset = Asset::where(['id' => $id])->first();
        if ($asset == null) {
            return null;
        }

        return $asset->getAsset();
    }

}
