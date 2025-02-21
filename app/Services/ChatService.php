<?php
namespace App\Services;

use App\Utils\IOpenAIAPIClient;
use App\Adapters\Score\IScoringAdapter;

class ChatService
{
    /**
     * チャットの返答を返す
     * @param string $message
     * @return string $answer
     */
    private $client;
    private $scoringAdapter;

    public function __construct(IOpenAIAPIClient $client, IScoringAdapter $scoringAdapter)
    {
        $this->client = $client;
        $this->scoringAdapter = $scoringAdapter;
    }

    public function response(string $message, string $conversationHistory)
    {
        $prompt = <<<EOF

        ###課題
        あなたは今チャットシステムのAIです。
        あなたはユーザーとの対話を通じて、芸術作品の趣味嗜好について探ろうとしています。
        ユーザーが投稿したメッセージに対して、適切な返答と、それに続く質問を返してください。

        ところで、あなたはこれまでにユーザーと会話しました。その会話の内容は以下の通りです。

        ###会話履歴
        $conversationHistory

        ###注意
        テンポよく返せるよう、６０文字程度での返答を心がけてください。

        ###質問
        $message        
        
        EOF;

        $answer = $this->client->fetchAnswer($prompt);
        return $answer;
    }

    public function getScore(string $conversationHistory)
    {
        $scoreString = $this->scoringAdapter->getScore($conversationHistory);
        $decodedScoreString = json_decode($scoreString, true);
        return $decodedScoreString;
    }
}
