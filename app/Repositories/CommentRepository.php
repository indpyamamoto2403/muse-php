<?php

namespace App\Repositories;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentRepository
{
    public function comment($artId, $comment)
    {
        $insComment = new Comment();
        $insComment->art_id = $artId;
        $insComment->user_id = Auth::id();
        $insComment->comment = $comment;
        $insComment->save();
    }
}