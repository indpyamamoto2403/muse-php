<?php

namespace App\Services;

use App\Repositories\ArtRepository;
use App\Repositories\EvaluationRepository;
use App\Models\Art;
use App\Models\Like;
use App\Models\Save;
use Illuminate\Support\Facades\DB;

class ArtService
{
    private $artRepository;

    /**
     * コンストラクタで Repository をnew.
     */
    public function __construct()
    {
        $this->artRepository = new ArtRepository();
    }



    /**
     * 全Art取得.
     */
    public function getAllArts()
    {
        // ここで必要なビジネスロジックがあれば適宜追加
        return $this->artRepository->getAll();
    }

    /**
     * 特定Artを取得.
     */
    public function getArt($id)
    {
        // ここで権限チェック等をする場合も
        return $this->artRepository->findById($id);
    }

    /**
     * Artを作成.
     */
    public function createArt(array $data)
    {
        // バリデーションや他の処理を挟むならここで
        return $this->artRepository->create($data);
    }

    /**
     * Artを更新.
     */
    public function updateArt($id, array $data)
    {
        // 何らかのビジネスロジックを追加する場合はここ
        return $this->artRepository->update($id, $data);
    }

    /**
     * Artを削除.
     */
    public function deleteArt($id)
    {
        return $this->artRepository->delete($id);
    }

    /**
     * ユーザーがいいねした作品を取得
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFavoriteArts($userId)
    {
        // ユーザーがいいねした作品IDを取得
        $favoriteArtIds = Like::where('user_id', $userId)
            ->pluck('art_id');
            
        // いいねした作品の詳細情報を取得
        return Art::with(['user', 'evaluation', 'likes', 'saves'])
            ->whereIn('id', $favoriteArtIds)
            ->get();
    }


    /**
     * ユーザーが保存した作品を取得
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSavedArts($userId)
    {
        // ユーザーが保存した作品IDを取得
        $savedArtIds = Save::where('user_id', $userId)
            ->pluck('art_id');
            
        // 保存した作品の詳細情報を取得
        return Art::with(['user', 'evaluation', 'likes', 'saves'])
            ->whereIn('id', $savedArtIds)
            ->get();
    }
}
