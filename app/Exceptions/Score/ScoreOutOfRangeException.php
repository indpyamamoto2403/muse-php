<?php

namespace App\Exceptions\Score;

use Exception;
use Illuminate\Support\Facades\Log;

class ScoreOutOfRangeException extends Exception
{
    /**
     * コンストラクタで初期メッセージやコードを設定
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "スコアが規定の範囲外です。", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * 例外発生時のログ出力処理をカスタマイズ
     */
    public function report()
    {
        Log::error('ScoreOutOfRangeException: ' . $this->getMessage());
        Log::error($this->getTraceAsString());
    }

    /**
     * HTTPリクエストに対してエラーレスポンスを返す
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'error'   => 'ScoreOutOfRangeException',
            'message' => $this->getMessage()
        ], 500);
    }
}
