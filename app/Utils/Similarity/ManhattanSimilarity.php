<?php

namespace App\Utils\Similarity;

use App\Utils\Similarity\ISimilarity;

class ManhattanSimilarity implements ISimilarity
{
    /**
     * Calculates the Manhattan similarity between two vectors.
     *
     * The similarity is computed as 1/(1 + Manhattan distance) to normalize it between 0 and 1.
     *
     * @param array<string, float|int> $vectorA
     * @param array<string, float|int> $vectorB
     * @return float
     */
    public function calculate(array $vectorA, array $vectorB): float
    {
        $sum = 0.0;
        foreach ($vectorA as $key => $valueA) {
            $valueB = $vectorB[$key] ?? 0;
            $sum += abs($valueA - $valueB);
        }
        return 1 / (1 + $sum);
    }
}
