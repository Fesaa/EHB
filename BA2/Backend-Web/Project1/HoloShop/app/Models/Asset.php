<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

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

    public static function fromURL(string $url): Asset {
        $asset = Asset::where(["data" => $url])->first();
        if ($asset == null) {
            $asset = new Asset();
            $asset->url = $url;
            $asset->save();
        }
        return $asset;
    }

    public static function fromData(UploadedFile $file): Asset {
        $data = base64_encode(file_get_contents($file));
        $asset = Asset::where(["data" => $data])->first();
        if ($asset == null) {
            $asset = new Asset();
            $asset->data = $data;
            $asset->save();
        }
        return $asset;
    }

}
