<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ConversationParticipant extends Model
{
    // conversation_participants テーブルは複合主キーを持つため、auto increment を無効にします。
    public $incrementing = false;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'recepter_id',
    ];

    /**
     * この参加情報が属する会話を取得
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * 参加しているユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
