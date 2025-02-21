<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Services\ChatService;
class ChatController extends Controller
{
    private $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        return Inertia::render('Chat/Index');
    }

    public function complete()
    {
        $score = $this->chatService->getLatestScore();
        return Inertia::render('Chat/Complete',[
            'score' => $score
        ]);
    }
}
