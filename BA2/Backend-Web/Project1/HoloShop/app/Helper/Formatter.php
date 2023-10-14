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
        // Define a regular expression to match [asset width=64 height=100]<int>[/asset] tags
        $pattern = '/\[asset id=(\d+)(:? width=(\d+))?(?: ?height=(\d+))?\]/';

        // Use preg_replace_callback to replace matched tags with image tags
        $content = preg_replace_callback($pattern, function($matches) {
            if (count($matches) < 2) {
                return "[Asset not found]";
            }

            $assetId = intval($matches[1]);
            $width = count($matches) > 3 ? intval($matches[3]) : 64;
            $height = count($matches) > 4 ? intval($matches[4]) : 64;

            if ($width > 528) {
                $width = 528;
            }

            if ($height > 528) {
                $height = 528;
            }

            // Use your database function to get the asset URL based on the ID
            $url = Asset::getAssetFromID($assetId);

            if ($url) {
                // Replace the [asset] tag with an img tag, including width and height
                return "<img src='$url' width='$width' height='$height' alt='Asset not found'>";
            } else {
                // Handle the case where the asset is not found in the database
                return "[Asset not found]";
            }
        }, $content);

        return $content;
    }
}
