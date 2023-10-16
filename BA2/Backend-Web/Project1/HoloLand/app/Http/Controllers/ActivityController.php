<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityController extends Controller
{


    public static function createEntry(int $user_id, string $url): void
    {
        static::update(null, $user_id, $url);
    }

    private static function update(int|null $id, int $user_id, string $url): void
    {
        if ($id != null) {
            $activity = Activity::find($id);
        }
        if ($id == null || $activity == null) {
            $activity = new Activity();
        }
        $activity->user_id = $user_id;
        $activity->url = $url;
        $activity->save();
    }

}
