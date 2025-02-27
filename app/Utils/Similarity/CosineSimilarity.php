<?php

namespace App\Utils\Similarity;
use App\Utils\Similarity\ISimilarity;
class CosineSimilarity implements ISimilarity
{
    /**
     * コサイン類似度を計算
     *
     * @param array<string, float|int> $vectorA
     * @param array<string, float|int> $vectorB
     * @return float
     */
    public function calculate(array $vectorA, array $vectorB): float
    {
        $dotProduct = 0.0; // 内積
        $magnitudeA = 0.0; // ベクトルAの大きさ
        $magnitudeB = 0.0; // ベクトルBの大きさ

        foreach ($vectorA as $key => $valueA) {
            $valueB = $vectorB[$key] ?? 0.0; // vectorBに値がなければ0
            $dotProduct += $valueA * $valueB;
            $magnitudeA += $valueA ** 2;
            $magnitudeB += $valueB ** 2;
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);
        return ($magnitudeA * $magnitudeB) ? $dotProduct / ($magnitudeA * $magnitudeB) : 0.0;
    }
}
