<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    // 会話テーブルはメタデータのみを保持するため fillable は空
    protected $fillable = [];

    // JSON出力時に計算属性も含めるため、appends に追加
    protected $appends = ['recepter_id'];

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

    /**
     * 受信者のID（自分以外のユーザーID）を計算して取得
     */
    public function getRecepterIdAttribute()
    {
        // conversationParticipants がロードされていない場合は明示的にロード
        if (!$this->relationLoaded('conversationParticipants')) {
            $this->load('conversationParticipants');
        }
        // 現在ログインしているユーザー以外の最初の参加者を取得
        $otherParticipant = $this->conversationParticipants
            ->firstWhere('user_id', '!=', Auth::id());
        return optional($otherParticipant)->user_id;
    }
}
