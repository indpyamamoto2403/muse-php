<?php

namespace App\Repositories;

use App\Models\Evaluation;

class EvaluationRepository
{
    /**
     * 新規にEvaluationを作成
     */
    public function create(array $data): Evaluation
    {
        return Evaluation::create($data);
    }

    /**
     * 単一のEvaluationを取得
     */
    public function find(int $id): ?Evaluation
    {
        return Evaluation::find($id);
    }

    /**
     * 全件または条件でEvaluationを取得
     */
    public function all()
    {
        return Evaluation::all();
    }

    /**
     * Evaluationを更新
     */
    public function update(Evaluation $evaluation, array $data): bool
    {
        return $evaluation->update($data);
    }

    /**
     * Evaluationを削除
     */
    public function delete(Evaluation $evaluation): ?bool
    {
        return $evaluation->delete();
    }

    public function getUserEvaluation($userId) : ?Evaluation
    {
        return Evaluation::where('user_id', $userId)->first();
    }
}