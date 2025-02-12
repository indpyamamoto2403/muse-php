<?php

namespace App\Services;

use App\Repositories\ArtRepository;
use App\Repositories\EvaluationRepository;

class ArtService
{
    private $artRepository;

    /**
     * コンストラクタで Repository をnew.
     */
    public function __construct()
    {
        // ご要望通り serviceコンストラクタ内で new
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
}
