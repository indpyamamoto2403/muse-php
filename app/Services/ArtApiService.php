<?php

namespace App\Services;

use App\Repositories\LikeRepository;
use App\Repositories\SaveRepository;
use App\Repositories\CommentRepository;
class ArtApiService
{

    /**
     * コンストラクタで Repository をnew.
     */
    private $likeRepository;
    private $saveRepository;
    private $commentRepository;

    public function __construct(LikeRepository $likeRepository, 
                                SaveRepository $saveRepository, 
                                CommentRepository $commentRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->saveRepository = $saveRepository;
        $this->commentRepository = $commentRepository;
    }


    public function like($artId, $userId)
    {
        $this->likeRepository->like($artId, $userId);
    }

    public function unlike($artId, $userId)
    {
        $this->likeRepository->unlike($artId, $userId);
    }

    public function save($artId, $userId)
    {
        $this->saveRepository->save($artId, $userId);
    }

    public function unsave($artId, $userId)
    {
        $this->saveRepository->unsave($artId, $userId);
    }

    public function comment($artId, $comment)
    {
        $this->commentRepository->comment($artId, $comment);
    }

    public function updateComment($commentId, $comment)
    {
        $this->commentRepository->updateComment($commentId, $comment);
    }
    
    public function deleteComment($commentId)
    {
        $this->commentRepository->deleteComment($commentId);
    }
}
