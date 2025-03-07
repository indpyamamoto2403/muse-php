<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Services\ChatService;
use App\Models\Question;

class ChatController extends Controller
{
    private $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }
    /**
     * AIによるチャット画面を同意
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Chat/Index');
    }


    /**
     * AIによる質問回答画面を同意
     */
    public function questions()
    {
        //ランダムに10個取得
        $questions = Question::inRandomOrder()->take(10)->get();
        return Inertia::render('Chat/Questions',[
            'questions' => $questions
        ]);
    }

    /**
     * AIによるスコアリング結果を表示
     */
    public function complete()
    {
        $score = $this->chatService->getLatestScore();
        return Inertia::render('Chat/Complete',[
            'score' => $score
        ]);
    }
}
