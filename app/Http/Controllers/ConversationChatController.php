<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Repositories\ConversationChatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ConversationChatController extends Controller
{
    protected $chatRepository;

    public function __construct(ConversationChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    /**
     * 会話一覧画面を表示する
     */
    public function index()
    {
        $userId = Auth::id();


        $conversations = Conversation::whereHas('conversationParticipants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['conversationParticipants.user', 'messages.sender'])->get();

        return Inertia::render('Conversations/Index', [
            'conversations' => $conversations,
        ]);
    }
    
    /**
     * 個別の会話を実装する
     * 
     */
    public function show(Request $request, int | string $recepterId)
    {
        $senderId = Auth::id();
        // 送信者と受信者間の既存の会話を検索
        $conversation = Conversation::whereHas('conversationParticipants', function ($query) use ($senderId) {
            $query->where('user_id', $senderId);
        })->whereHas('conversationParticipants', function ($query) use ($recepterId) {
            $query->where('user_id', $recepterId);
        })->first();
        

        // 既存の会話がなければ新たに作成する
        if (!$conversation) {
            $conversation = $this->chatRepository->createConversation($senderId, $recepterId);
        }
    
        // 関連する参加者とメッセージ情報を読み込む
        $conversation->load(['conversationParticipants.user', 'messages.sender']);

        return Inertia::render('Conversations/Show', [
            'conversation' => $conversation,
        ]);
    }

    /**
     * メッセージ送信処理
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'recepter_id' => 'required|integer',
            'content'     => 'required|string',
        ]);

        $senderId   = Auth::id();
        $recepterId = $request->input('recepter_id');
        $content    = $request->input('content');

        // 送信者と受信者間の既存の会話を検索
        $conversation = Conversation::whereHas('conversationParticipants', function ($query) use ($senderId) {
            $query->where('user_id', $senderId);
        })->whereHas('conversationParticipants', function ($query) use ($recepterId) {
            $query->where('user_id', $recepterId);
        })->first();

        // 既存の会話がなければ新たに作成する
        if (!$conversation) {
            $conversation = $this->chatRepository->createConversation($senderId, $recepterId);
        }

        // 会話に対してメッセージを送信する
        $this->chatRepository->sendMessage($conversation->id, $senderId, $content);

        // メッセージ送信後は、個別会話画面へリダイレクトする
        return redirect()->route('conversations.show', $recepterId)
                         ->with('success', 'Message sent successfully.');
    }
}
