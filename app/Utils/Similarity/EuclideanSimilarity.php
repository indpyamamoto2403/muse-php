<?php

namespace App\Utils\Similarity;

use App\Utils\Similarity\ISimilarity;

class EuclideanSimilarity implements ISimilarity
{
    /**
     * Calculates the Euclidean similarity between two vectors.
     *
     * The similarity is computed as 1/(1 + Euclidean distance) to normalize it between 0 and 1.
     *
     * @param array<string, float|int> $vectorA
     * @param array<string, float|int> $vectorB
     * @return float
     */
    public function calculate(array $vectorA, array $vectorB): float
    {
        $sumSquares = 0.0;
        foreach ($vectorA as $key => $valueA) {
            $valueB = $vectorB[$key] ?? 0;
            $sumSquares += ($valueA - $valueB) ** 2;
        }
        $distance = sqrt($sumSquares);
        return 1 / (1 + $distance);
    }
}
