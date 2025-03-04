<?php

namespace App\Repositories;
use App\Models\Like;

class LikeRepository
{
    public function like($artId, $userId)
    {
        $like = new Like();
        $like->user_id = $userId;
        $like->art_id = $artId;
        $like->save();
    }

    public function unlike($artId, $userId)
    {
        $like = Like::where('art_id', $artId)->where('user_id', $userId)->first();
        $like->delete();
    }
}