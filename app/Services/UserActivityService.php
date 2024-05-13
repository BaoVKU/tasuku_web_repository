<?php
namespace App\Services;

use App\Events\OnlineEvent;
use Illuminate\Support\Facades\Cache;

class UserActivityService
{
    public function connect($id)
    {
        event(new OnlineEvent($id, true));

        $existingUserIds = Cache::get('authenticated_user_ids', []);

        if (!in_array($id, $existingUserIds)) {
            $existingUserIds[] = $id;
            Cache::forever('authenticated_user_ids', $existingUserIds);
        }

        return $existingUserIds;
    }

    public function disconnect($id)
    {
        event(new OnlineEvent($id, false));

        $existingUserIds = Cache::get('authenticated_user_ids', []);
        $key = array_search($id, $existingUserIds);

        if ($key !== false) {
            unset($existingUserIds[$key]);
            Cache::forever('authenticated_user_ids', array_values($existingUserIds));
        }
    }

}
