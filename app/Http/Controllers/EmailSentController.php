<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailRequest;
use App\Services\EmailService;

class EmailSentController extends Controller
{
    public function sendEmail(SendEmailRequest $request)
    {
        EmailService::handleEmailSending($request->file('pdf'));

        return response()->json(['message' => 'Email sent successfully']);
    }
}
