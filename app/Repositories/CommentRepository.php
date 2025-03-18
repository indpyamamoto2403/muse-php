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

    public function updateComment($commentId, $comment)
    {
        $updComment = Comment::find($commentId);
        $updComment->comment = $comment;
        $updComment->save();
    }

    public function deleteComment($commentId)
    {
        $delComment = Comment::find($commentId);
        $delComment->delete();
    }
}