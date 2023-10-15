<?php

namespace App\Helper;

use App\Models\Asset;
use PheRum\BBCode\Facades\BBCode;

class Formatter
{

    public static function apply(string $content): string
    {
        $content = preg_replace('/<script>.*<\/script>/s', '', $content);
        $content = static::replaceAssetTags($content);
        return BBCode::parse($content);
    }

    private static function replaceAssetTags($content) {
        $pattern = '/\[asset id=(\d+)(?: width=(\d+))?(?: ?height=(\d+))?\]/';

        $content = preg_replace_callback($pattern, function($matches) {
            if (count($matches) < 2) {
                return "[Asset not found]";
            }

            $assetId = intval($matches[1]);
            $width = count($matches) > 2 ? intval($matches[2]) : 64;
            $height = count($matches) > 3 ? intval($matches[3]) : 64;

            if ($width > 528) {
                $width = 528;
            }

            if ($height > 528) {
                $height = 528;
            }

            $url = Asset::getAssetFromID($assetId);

            if ($url) {
                return "<img src='$url' width='$width' height='$height' alt='Asset not found'>";
            } else {
                return "[Asset not found]";
            }
        }, $content);

        return $content;
    }
}
