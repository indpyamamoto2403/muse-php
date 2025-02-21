<?php

namespace App\Adapters\Score;
interface IScoringAdapter
{
    /**
     * @param string $conversation_history
     * @return string|null $score
     * @note Jsonデコードを行う必要あり
     * {
     * "style": 3,
     * "tradition_innovation": 3,
     * "introspective_emotional": 3,
     * "color_sense": 3,
     * "composition": 3,
     * "technique": 3,
     * "theme": 3,
     * "energy": 3,
     * "uniqueness": 3
     * }
     */
    public function getScore(string $conversation_history): string | null;
}
