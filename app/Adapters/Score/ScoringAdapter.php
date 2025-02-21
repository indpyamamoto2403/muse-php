<?php

namespace App\Adapters\Score;
use App\Adapters\Score\IScoringAdapter;
use App\Utils\OpenAIAPIClient;
use Illuminate\Support\Facades\Log;
class ScoringAdapter implements IScoringAdapter
{
    private $client;

    public function __construct()
    {
        $this->client = new OpenAIAPIClient;
    }
    public function getScore(string $conversationHistory): string | null
    {
        $prompt = <<<EOF

            ## 会話履歴
            $conversationHistory

            ## 課題
            あなたは今チャットシステムのAIです。
            会話履歴をもとに、ユーザーの芸術作品に対する評価を行います。
            以下の項目に基づいて、以下の項目に出力してください。

            ## 評価項目
            style: 1-5
            tradition_innovation: 1-5
            introspective_emotional: 1-5
            color_sense: 1-5
            composition: 1-5
            technique: 1-5
            theme: 1-5
            energy: 1-5
            uniqueness: 1-5

            ## 出力形式
            JSON文字列

            ## 出力例
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

        $answer = $this->client->fetchAnswer($prompt);
        return $answer;

    }
}