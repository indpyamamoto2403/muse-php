<?php

namespace App\Repositories;

use App\Models\Art;

class ArtRepository
{
    /**
     * 全件取得.
     */
    public function getAll()
    {
        return Art::all();
    }

    /**
     * 特定IDのArtを取得.
     */
    public function findById($id)
    {
        return Art::findOrFail($id);
    }

    /**
     * 作成.
     */
    public function create(array $data)
    {
        return Art::create($data);
    }

    /**
     * 更新.
     */
    public function update($id, array $data)
    {
        $art = $this->findById($id);
        $art->update($data);
        return $art;
    }

    /**
     * 削除.
     */
    public function delete($id)
    {
        $art = $this->findById($id);
        $art->delete();
        return true;
    }
}
