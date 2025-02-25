<?php

namespace App\Utils;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class VoiceProvider {
    private $speechRegion;
    private $speechKey;
    private $endpoint;
    private $outputFormat;

    /**
     * コンストラクタ
     * 
     * @param string $speechRegion 例: "eastus", "japanwest" など
     * @param string $speechKey Microsoft Cognitive Servicesのサブスクリプションキー
     * @param string $outputFormat 出力フォーマット。デフォルトは 'audio-16khz-128kbitrate-mono-mp3'
     */
    public function __construct($speechRegion, $speechKey, $outputFormat = 'audio-16khz-128kbitrate-mono-mp3') {
        $this->speechRegion = $speechRegion;
        $this->speechKey = $speechKey;
        $this->outputFormat = $outputFormat;
        $this->endpoint = "https://japaneast.api.cognitive.microsoft.com/";
    }

    /**
     * テキストを音声に変換する
     *
     * @param string $text 読み上げるテキスト
     * @param string $voice 使用する音声の名前。デフォルトは 'en-US-AvaMultilingualNeural'
     * @param string $lang 言語コード。デフォルトは 'en-US'
     * @param string $gender 音声の性別。デフォルトは 'Female'
     * @return string 生成された音声のバイナリデータ
     * @throws Exception GuzzleのエラーやHTTPエラーの場合に例外をスロー
     */
    public function synthesize($text, $voice = 'en-US-AvaMultilingualNeural', $lang = 'en-US', $gender = 'Female') {
        // SSML形式のリクエストボディを作成
        $ssml = "<speak version='1.0' xml:lang='{$lang}'>";
        $ssml .= "<voice xml:lang='{$lang}' xml:gender='{$gender}' name='{$voice}'>";
        $ssml .= htmlspecialchars($text, ENT_QUOTES | ENT_XML1);
        $ssml .= "</voice></speak>";

        // Guzzleクライアントの作成
        $client = new Client();

        try {
            $response = $client->request('POST', $this->endpoint, [
                'headers' => [
                    "Ocp-Apim-Subscription-Key" => $this->speechKey,
                    "Content-Type"               => "application/ssml+xml",
                    "X-Microsoft-OutputFormat"   => $this->outputFormat,
                    "User-Agent"                 => "PHPVoiceProvider"
                ],
                'body'        => $ssml,
                // http_errors を false にすると、HTTPエラーコードの場合でも例外が発生しなくなるため、後でチェックできます
                'http_errors' => false,
            ]);
        } catch (RequestException $e) {
            throw new Exception("Guzzleエラー: " . $e->getMessage());
        }

        // HTTPステータスコードの確認
        if ($response->getStatusCode() !== 200) {
            $result = $response->getBody()->getContents();
            throw new Exception("HTTPエラーコード: " . $response->getStatusCode() . ". レスポンス: " . $result);
        }

        return $response->getBody()->getContents();
    }
}

try {
    $speechRegion = env('SPEECH_REGION'); // 例: eastus, japanwest など（.env等で正しく設定してください）
    $speechKey = env('SPEECH_KEY'); // サブスクリプションキーを環境変数から取得
    $voiceProvider = new VoiceProvider($speechRegion, $speechKey);

    // テキストを音声に変換
    $text = "my voice is my passport verify me";
    $audioData = $voiceProvider->synthesize($text);

    // 結果をファイルに保存
    file_put_contents("output.mp3", $audioData);
    echo "音声ファイル 'output.mp3' を作成しました。";
} catch (Exception $e) {
    echo "エラーが発生しました: " . $e->getMessage();
}
