<?php

namespace App\Exceptions\Score;

use Exception;
use Illuminate\Support\Facades\Log;

class ScoreFailedToSaveException extends Exception
{
    /**
     * コンストラクタで初期メッセージやコードを設定
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "スコアの保存に失敗しました。", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * 例外発生時のログ出力処理をカスタマイズ
     */
    public function report()
    {
        Log::error('ScorFailedToSaveException: ' . $this->getMessage());
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
            'error'   => 'ScorFailedToSaveException',
            'message' => $this->getMessage()
        ], 500);
    }
}
