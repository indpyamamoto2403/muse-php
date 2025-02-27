<?php

namespace App\Utils\Similarity;

interface ISimilarity
{
    /**
     * 2つのベクトルの類似度を計算する
     *
     * @param array $vectorA
     * @param array $vectorB
     * @return float
     */
    public function calculate(array $vectorA, array $vectorB): float;
}
