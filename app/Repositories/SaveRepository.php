<?php

namespace App\Repositories;
use App\Models\Save;

class SaveRepository
{
    public function save($artId, $userId)
    {
        $like = new Save();
        $like->user_id = $userId;
        $like->art_id = $artId;
        $like->save();
    }

    public function unsave($artId, $userId)
    {
        $like = Save::where('art_id', $artId)->where('user_id', $userId)->first();
        $like->delete();
    }
}