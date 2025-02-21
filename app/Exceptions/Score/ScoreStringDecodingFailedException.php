<?php

namespace App\Exceptions\Score;

use Exception;
use Illuminate\Support\Facades\Log;
class ScoreStringDecodingFailedException extends Exception
{
    /**
     * コンストラクタで初期メッセージやコードを設定
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "Score文字列のデコードに失敗しました。", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * 例外発生時のログ出力処理をカスタマイズ
     */
    public function report()
    {
        Log::error('ScoreStringDecodingFailedException: ' . $this->getMessage());
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
            'error'   => 'ScoreStringDecodingFailedException',
            'message' => $this->getMessage()
        ], 500);
    }
}
