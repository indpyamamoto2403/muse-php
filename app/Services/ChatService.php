<?php
namespace App\Services;

use App\Utils\IOpenAIAPIClient;
use App\Adapters\Score\IScoringAdapter;
use App\Repositories\ChatRepository;
use App\Exceptions\Score\ScoreStringDecodingFailedException;
use App\Exceptions\Score\ScoreOutOfRangeException;
use App\Exceptions\Score\ScoreFailedToSaveException;
use App\Repositories\AnswerHistoryRepository;
use App\Utils\VoiceProvider;

use Illuminate\Support\Facades\Log;
class ChatService
{
    /**
     * チャットの返答を返す
     * @param string $message
     * @return string $answer
     */
    private $client;
    private $scoringAdapter;
    private $voiceProvider;
    private $chatRepository;
    private $answerHistoryRepository;

    public function __construct(IOpenAIAPIClient $client, IScoringAdapter $scoringAdapter, AnswerHistoryRepository $answerHistoryRepository)
    {
        $this->client = $client;
        $this->scoringAdapter = $scoringAdapter;
        $this->chatRepository = new ChatRepository();
        $this->voiceProvider = new VoiceProvider(env('SPEECH_REGION'), env('SPEECH_KEY'));
        $this->answerHistoryRepository = $answerHistoryRepository;
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

    /**
     * 音声ファイルを生成し、そのURLを返す
     * @param string $message
     * @return string $audioURL
     */
    public function createVoice(string $message)
    {
        $audioURL = $this->voiceProvider->createAndGetAudioURL($message);
        return $audioURL;
    }


    /**
     * 会話履歴からスコアを導出し、保存まで行う
     */
    public function processScore(string $conversationHistory)
    {
        $score = $this->getScore($conversationHistory);
        $this->saveScore($score);
        return $score;
    }

    /**
     * 会話履歴からスコアを導出する
     */
    public function getScore(string $conversationHistory) : array
    {
        $scoreString = $this->scoringAdapter->getScore($conversationHistory);

        try{
            $decodedScoreString = json_decode($scoreString, true);
        }catch(ScoreStringDecodingFailedException $e){
            throw new ScoreStringDecodingFailedException();
        }

        //各値が1-5の間に収まっているか検証
        $this->validateScoreInCorrectRange($decodedScoreString);

        
        return $decodedScoreString;
    }

    public function validateScoreInCorrectRange(array $score)
    {
        foreach($score as $key => $value){
            if($value < 1 || $value > 5){
                throw new ScoreOutOfRangeException();
            }
        }
    }

    /**
     * スコアを保存する
     */
    public function saveScore(array $score)
    {
        try{
            $this->chatRepository->save($score);
        }catch(ScoreFailedToSaveException $e){
            throw new ScoreFailedToSaveException();
        }
    }

    /**
     * 最新のスコアを取得する
     */
    public function getLatestScore()
    {
        return $this->chatRepository->getLatest();
    }

    /**
     * 回答を保存する
     */
    public function saveAnswers(array $payload): void
    {
        foreach($payload as $answer){
            $this->answerHistoryRepository->create($answer['question_id'], $answer['answer_id']);
        }
    }
}
