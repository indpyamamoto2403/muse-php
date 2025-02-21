<?php

namespace App\Adapters\Score;

interface IScoringAdapter
{
    /**
     * @param string $conversationHistory
     * @return string|null $score
     * @note Jsonデコードを行う必要あり
     * {
     * "style": 3,
     * "traditionInnovation": 3,
     * "introspectiveEmotional": 3,
     * "colorSense": 3,
     * "composition": 3,
     * "technique": 3,
     * "theme": 3,
     * "energy": 3,
     * "uniqueness": 3
     * }
     */
    public function getScore(string $conversationHistory): string | null;
}