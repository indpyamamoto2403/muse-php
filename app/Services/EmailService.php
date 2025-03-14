<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\ScoreReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\EmailHistoryRepository;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;



class EmailService
{

    public static function generateDashboardPDF($view, $data)
    {
        // Create and configure options
        $options = new Options();
        
        // フォントディレクトリを設定
        $fontDir = public_path('fonts/');
        $options->set('fontDir', $fontDir);
        
        // フォントキャッシュの設定
        $options->set('fontCache', storage_path('fonts/'));
        
        // リモートコンテンツを有効化
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        // DOMPDFの文字エンコーディングをUTF-8に設定
        $options->set('chroot', public_path());
        
        $dompdf = new Dompdf($options);
        
        // 日本語フォントを明示的に登録
        $dompdf->getFontMetrics()->registerFont(
            ['family' => 'ipag', 'style' => 'normal', 'weight' => 'bold'],
            $fontDir . '/ipaexg.ttf'
        );
        
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->set_option('defaultFont', 'ipag');
        $html = view($view, $data)->render();
        
        // HTMLに明示的なフォント指定を追加（必要に応じて）
        $html = '<style>body { font-family: ipag, sans-serif; }</style>' . $html;
        
        // UTF-8指定で読み込み
        $dompdf->loadHtml($html, 'UTF-8');
        
        // Render PDF
        $dompdf->render();
        
        // Get output
        $pdf = $dompdf->output();
        return $pdf;
    }


    /**
     * スコアリング評価メールを送信する
     *
     * @param string $pdfPath
     * @param EmailHistoryRepository $emailHistoryRepository
     * @return bool
     */
    public static function sendScoringEvaluationEmail($pdfPath, EmailHistoryRepository $emailHistoryRepository)
    {
        try {
            // 表示用のファイル名
            $displayFileName = 'スコア評価レポート.pdf';
            
            // ビューにファイル名を渡す
            Mail::send('emails.scoring-evaluation', [
                'user' => Auth::user(),
                'pdfFileName' => $displayFileName
            ], function ($message) use ($pdfPath, $displayFileName) {
                $message->to('yamamoto@indp.co.jp')
                        ->subject('スコア評価レポート')
                        ->attach(storage_path('app/public/' . $pdfPath), [
                            'as' => $displayFileName,
                            'mime' => 'application/pdf'
                        ]);
            });
            
            return true;
        } catch (Exception $e) {
            Log::error('メール送信中にエラーが発生しました: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * メール送信処理
     *
     * @param \Illuminate\Http\UploadedFile $pdf
     * @return string|bool PDFパスまたは失敗した場合はfalse
     */
    public static function handleEmailSending($pdf)
    {
        try {
            // ファイル名を生成
            $filename = 'dashboard_' . Str::uuid() . '.pdf';
            $pdfPathInStorage = 'emails/' . $filename; // storage/public/emails ディレクトリに保存

            Storage::disk('public')->put($pdfPathInStorage, $pdf);

            $result = self::sendScoringEvaluationEmail($pdfPathInStorage, app(EmailHistoryRepository::class));

            return $result ? $pdfPathInStorage : false;

        } catch (Exception $e) {
            Log::error('Email handling error: ' . $e->getMessage());
            return false;
        }
    }
}
