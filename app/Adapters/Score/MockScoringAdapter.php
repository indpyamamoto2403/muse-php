<?php

namespace App\Adapters\Score;
use App\Adapters\Score\IScoringAdapter;
class MockScoringAdapter implements IScoringAdapter
{
    /**
     * モック実装として、各スコア項目の平均値を計算して返します。
     *
     * @param string $conversationHistory 例:
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
    public function getScore(string $conversationHistory): string | null
    {
        return <<<EOF
            {
                "style": 3,
                "tradition_innovation": 3,
                "introspective_emotional": 3,
                "color_sense": 3,
                "composition": 3,
                "technique": 3,
                "theme": 3,
                "energy": 3,
                "uniqueness": 3
            }
            EOF;
    }
}