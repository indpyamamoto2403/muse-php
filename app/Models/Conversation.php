<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    // このテーブルは単に会話のメタデータのみを保持します。
    // 現状、追加のカラムがないので fillable は空です。
    protected $fillable = [];

    /**
     * この会話に参加しているユーザー（会話参加情報）を取得
     */
    public function conversationParticipants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    /**
     * この会話に属するメッセージを取得
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}