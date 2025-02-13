<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\ChatService;
use Illuminate\Support\Facades\Log;
class ChatAPIController extends Controller
{
    private $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function send(Request $request)
    {
        Log::debug($request->message);
        $message = $this->chatService->response($request->message);
        return response()->json(['message' => $message]);
    }
}
