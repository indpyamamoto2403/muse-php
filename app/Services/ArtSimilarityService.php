<?php

namespace App\Services;

use App\Models\Art;
use App\Models\Evaluation;
use Illuminate\Support\Collection;
use App\Utils\Similarity\ISimilarity;

class ArtSimilarityService
{
    private ISimilarity $similarity;
    public function __construct(ISimilarity $similarity){
        $this->similarity = $similarity;
    }

    /**
     * ユーザーの評価データを取得
     * @param int $userId
     * @return ?UserEvaluation
     */
    public function getUserEvaluation(int $userId): ?Evaluation
    {
        return Evaluation::where('user_id', $userId)->first();
    }

    
    /**
     * すべてのアート作品の評価データを取得
     * @return Collection<int, Art>
     */
    public function getAllArtEvaluations(): Collection
    {
        return Evaluation::where('art_id', '<>', null)->get();
    }


    /**
     * アート作品を類似度順にランク付け
     * @param int $userId
     * @return collection<int, art_id, similarity: float>
     */
    public function getRank(int $userId) : ?Collection
    {
        $userEvaluation = $this->getUserEvaluation($userId);
        
        // ユーザーの評価がない場合はnullを返す
        if ($userEvaluation === null) {
            return null;
        }
        
        // ユーザーの評価をベクトルに変換
        $userVector = [
            'style' => (float) $userEvaluation->style,
            'tradition_innovation' => (float) $userEvaluation->tradition_innovation,
            'introspective_emotional' => (float) $userEvaluation->introspective_emotional,
            'color_sense' => (float) $userEvaluation->color_sense,
            'composition' => (float) $userEvaluation->composition,
            'technique' => (float) $userEvaluation->technique,
            'theme' => (float) $userEvaluation->theme,
            'energy' => (float) $userEvaluation->energy,
            'uniqueness' => (float) $userEvaluation->uniqueness
        ];

        $artEvaluations = $this->getAllArtEvaluations();

        $rankedArtEvaluations = $artEvaluations->map(function ($evaluation) use ($userVector) {
             $artVector = [ 
                'style' => (float) $evaluation->style,
                'tradition_innovation' => (float) $evaluation->tradition_innovation,
                'introspective_emotional' => (float) $evaluation->introspective_emotional,
                'color_sense' => (float) $evaluation->color_sense,
                'composition' => (float) $evaluation->composition,
                'technique' => (float) $evaluation->technique,
                'theme' => (float) $evaluation->theme,
                'energy' => (float) $evaluation->energy,
                'uniqueness' => (float) $evaluation->uniqueness,
            ];

            $similarity = $this->similarity->calculate($userVector, $artVector);
            
            return [
                'art' => $evaluation->art_id,
                'similarity' => $similarity
            ];
        });
        return $rankedArtEvaluations;
    }

    /**
     * 類似度をアート作品に付与 故にコレクションを入力とし、コレクションを返す
     * @param Collection $arts
     * @param Collection $rankedArtEvaluations
     * @return Collection
     */
    public function getRankedArts(Collection $arts, Collection $rankedArtEvaluations): Collection
    {
        $rankedArt = $arts->map(function ($art) use ($rankedArtEvaluations) {
            $similarity = $rankedArtEvaluations->firstWhere('art', $art->id);
            $art->similarity = $similarity['similarity'] ?? null;
            return $art;
        })->sortByDesc('similarity')->values();

        return $rankedArt;
    }
}
