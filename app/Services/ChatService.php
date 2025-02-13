<?php
namespace App\Services;

use App\Utils\OpenAIAPIClient;

class ChatService
{
    /**
     * チャットの返答を返す
     * @param string $message
     * @return string $answer
     */
    private $client;
    public function __construct()
    {
        $this->client = new OpenAIAPIClient();
    }
    public function response(string $message)
    {
        $prompt = <<<EOF

        ###課題
        あなたは今チャットシステムのAIです。
        あなたはユーザーとの対話を通じて、芸術作品の趣味嗜好について探ろうとしています。
        ユーザーが投稿したメッセージに対して、適切な返答と、それに続く質問を返してください。

        例：最近見た映画はいつ？　、　好きな色は何色？など
        
        また、テンポよく返せるよう、３０文字程度での返答を心がけてください。

        ###質問
        $message        
        
        EOF;

        $answer = $this->client->fetchAnswer($prompt);
        return $answer;
    }
}