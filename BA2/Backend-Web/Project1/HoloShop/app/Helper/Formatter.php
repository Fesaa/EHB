<?php

namespace App\Helper;

use App\Models\Asset;
use DateTime;
use PheRum\BBCode\BBCodeParser;
use PheRum\BBCode\Facades\BBCode;

class Formatter
{

    public static function apply(string $content): string
    {
        $content = preg_replace('/<script>.*<\/script>/s', '', $content);
        $content = static::replaceAssetTags($content);
        $content = str_replace("\n", '<br>', $content);
        return BBCode::parse($content);
    }

    public static function applyTitle(string $content): string
    {
        $parser = new BBCodeParser();
        $content = preg_replace('/<script>.*<\/script>/s', '', $content);
        return $parser->only('size', 'bold', 'italic', 'color', 'center', 'underline')->parse($content);
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

    public static function date(DateTime $dateTime) {
        return $dateTime->format('M d, o');
    }

    public static function timeAgo(DateTime $dateTime) {
        $now = new DateTime();
        $interval = $now->diff($dateTime);

        if ($interval->d > 0) {
            $daysAgo = $interval->d;
            return $daysAgo . ($daysAgo == 1 ? ' day' : ' days') . ' ago';
        } else {
            $hoursAgo = $interval->h;
            $minutesAgo = $interval->i;

            $result = '';

            if ($hoursAgo > 0) {
                $result .= $hoursAgo . ($hoursAgo == 1 ? ' hour' : ' hours');
            }

            if ($minutesAgo > 0) {
                if ($hoursAgo > 0) {
                    $result .= ' ';
                }
                $result .= $minutesAgo . ($minutesAgo == 1 ? ' minute' : ' minutes');
            }

            if ($result == '') {
                return 'Just now';
            }

            return $result . ' ago';
        }
    }
}
