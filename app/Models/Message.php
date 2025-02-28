<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'read_at'
    ];

    /**
     * このメッセージが属する会話を取得
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * メッセージ送信者（ユーザー）を取得
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}