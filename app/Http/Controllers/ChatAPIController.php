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
    /**
     * 単体でメッセージを送る場合のAPI
     * @param Request $request
     * @return void
     */
    public function send(Request $request)
    {
        $message = $this->chatService->response($request->message, $request->conversationHistory);
        return response()->json(['message' => $message]);
    }

    /**
     * 全体のメッセージを送る場合のAPI
     * @param Request $request
     * @return void
     */
    public function sendAll(Request $request)
    {
        $score = $this->chatService->processScore($request->conversationHistory);
        return response()->json($score);
    }
}
