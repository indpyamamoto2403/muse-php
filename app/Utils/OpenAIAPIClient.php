<?php
namespace App\Utils;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\DomainLogic\Prompts\Prompts;

class OpenAIAPIClient implements IOpenAIAPIClient
{
    protected $openAIAPIKey;
    protected $openAIEndpoint;
    public function __construct()
    {
        $this->openAIAPIKey = env('OPENAI_API_KEY');
        $this->openAIEndpoint = env('OPENAI_ENDPOINT');
    }

    /**
    * テキストのみでAIに質問をして回答を取得する
    * @param string $prompt プロンプトテキスト
    */
    public function fetchAnswer(string $prompt): string|array
    {
        $payload = [
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt,
                    "model" => "gpt-4o",
                ]
            ],
                "temperature" => 0.1,
                "top_p" => 0.95,
                "max_tokens" => 4000
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
                'api-key' => $this->openAIAPIKey,
        ])->withOptions([
            'verify' => false,  // SSL証明書の確認を無効にする
        ])->post($this->openAIEndpoint, $payload);
        
        Log::info('Successfully fetched data from API', ['status' => $response->status()]);

        if ($response->failed()) {
            Log::error('Failed to fetch data from API', ['status' => $response->status(), 'error' => $response->body()]);
            return "Error in fetching the answer.";
        }
        $data = $response->getBody()->getContents();
        $decoded_data = json_decode($data, true);
        $content = $decoded_data['choices'][0]['message']['content'];
        return $content;
    }

    /**
     * 画像のOCRを実行し、AIで質問に回答する
     * @param string $prompt プロンプトテキスト
     * @param string $encodedImage Base64エンコードされた画像
     */
    public function fetchAnswerWithImage(string $prompt, string $encodedImage): string|array
    {
        $payload = [
            "messages" => [
                [
                    "role" => "user",
                    "content" => [
                        ["type" => "text", "text" => $prompt],
                        [
                            "type" => "image_url",
                            "image_url" => [
                                "url" => "data:image/jpg;base64,{$encodedImage}"
                            ],
                        ],
                    ]
                ]
            ],
            "temperature" => 0.1,
            "top_p" => 0.95,
            "max_tokens" => 4000
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api-key' => $this->openAIAPIKey,
            ])->withOptions([
                'verify' => false,  // Disable SSL verification
            ])->post($this->openAIEndpoint, $payload);

            // ステータスコードが200でなければエラーを返す
            if ($response->failed()) {
                Log::error('Failed to fetch data from API', ['status' => $response->status(), 'error' => $response->body()]);
                return "Error in fetching the answer.";
            }

            Log::info('Successfully fetched data from API', ['status' => $response->status()]);

            $data = $response->getBody()->getContents();
            $decoded_data = json_decode($data, true);
            $content = $decoded_data['choices'][0]['message']['content'];
            return $content;

        } catch (\Exception $e) {
            Log::error('Failed to make the request.', ['error' => $e->getMessage()]);
            return "Error in fetching the answer.";
        }
    }

}