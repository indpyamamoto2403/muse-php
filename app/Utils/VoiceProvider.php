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
        $this->endpoint = "https://japaneast.tts.speech.microsoft.com/cognitiveservices/v1";
    }

    /**
     * テキストを音声に変換し、ストレージに保存してURLを取得する
     * @param string $text 読み上げるテキスト
     * @param string $voice 使用する音声の名前。デフォルトは 'en-US-AvaMultilingualNeural'
     * //他の音声名は en-US-GuyNeural, en-US-JennyNeural, en-US-AriaNeural など
     * (参照先) https://learn.microsoft.com/en-us/azure/ai-services/speech-service/language-support?tabs=tts
     * @param string $lang 言語コード。デフォルトは 'en-US'
     * @param string $gender 音声の性別。デフォルトは 'Female'
     * @return string 生成された音声ファイルのURL
     * @throws Exception GuzzleのエラーやHTTPエラーの場合に例外をスロー
    */
    public function createAndGetAudioURL($text, $voice = 'en-GB-OllieMultilingualNeural', $lang = 'en-US', $gender = 'Female') {
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
             'http_errors' => false,
          ]);
       } catch (RequestException $e) {
          throw new Exception("Guzzleエラー: " . $e->getMessage());
       } catch (Exception $e) {
          throw new Exception("Unexpected error: " . $e->getMessage());
       }

       // HTTPステータスコードの確認
       if ($response->getStatusCode() !== 200) {
          $result = $response->getBody()->getContents();
          throw new Exception("HTTPエラーコード: " . $response->getStatusCode() . ". レスポンス: " . $result);
       }

       // ストレージに音声データを書き込む
       $fileName = 'audios/' . uniqid('voice_', true) . '.mp3';
       $filePath = storage_path('app/public/' . $fileName);
       file_put_contents($filePath, $response->getBody()->getContents());

       // ファイルのURLを返す
       return asset('storage/' . $fileName);
    }
}
