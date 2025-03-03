<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class ConversationChatRepository
{
    /**
     * 2人のユーザー間で新しい会話を作成する
     * @param int $userOneId
     * @param int $userTwoId
     * @return \App\Models\Conversation
     */
    public function createConversation(int $userOneId, int $userTwoId)
    {
        return DB::transaction(function () use ($userOneId, $userTwoId) {
            $conversation = Conversation::create();
            // 会話参加者情報を登録（参加者は必ず2人）
            $conversation->conversationParticipants()->createMany([
                ['user_id' => $userOneId],
                ['user_id' => $userTwoId],
            ]);

            return $conversation;
        });
    }

    /**
     * 指定した会話IDの会話を、参加者情報とメッセージも含めて取得する
     *
     * @param int $conversationId
     * @return \App\Models\Conversation|null
     */
    public function getConversation(int $conversationId)
    {
        return Conversation::with(['conversationParticipants.user', 'messages.sender'])
            ->find($conversationId);
    }

    /**
     * 会話内でメッセージを送信する
     *
     * @param int $conversationId
     * @param int $senderId
     * @param string $content
     * @return \App\Models\Message
     */
    public function sendMessage(int $conversationId, int $senderId, string $content)
    {
        return Message::create([
            'conversation_id' => $conversationId,
            'sender_id'       => $senderId,
            'content'         => $content,
        ]);
    }
}
