<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailHistory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SendEmailRequest;
use App\Repositories\EmailHistoryRepository;
use App\Services\EmailService;
use App\Mail\ScoreReportMail;
use App\Models\Evaluation;
use Dompdf\Dompdf; // Dompdf クラスを use する
use Dompdf\Options; // Dompdf\Options クラスを use する

class EmailController extends Controller
{
    protected $emailService;
    protected $emailHistoryRepository;

    public function __construct(EmailService $emailService, EmailHistoryRepository $emailHistoryRepository)
    {
        $this->emailService = $emailService;
        $this->emailHistoryRepository = $emailHistoryRepository;
    }

    /**
     * ダッシュボードをPDF化して送信する新しいメソッド
     */
    public function sendEmail(Request $request)
    {
        $pdf = EmailService::generateDashboardPDF('pdf.dashboard', ['user' => Auth::user()]);
        $result = EmailService::handleEmailSending($pdf);
        return redirect()->back()->with('message', $result ? 'Email sent successfully' : 'Email sending failed');
    }
}
