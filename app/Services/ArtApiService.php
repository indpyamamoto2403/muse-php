<?php

namespace App\Services;

use App\Repositories\LikeRepository;
use App\Repositories\SaveRepository;

class ArtApiService
{

    /**
     * コンストラクタで Repository をnew.
     */
    private $likeRepository;
    private $saveRepository;

    public function __construct(LikeRepository $likeRepository, SaveRepository $saveRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->saveRepository = $saveRepository;
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
}
