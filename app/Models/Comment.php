<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'art_id',
        'user_id',
        'comment',
        'created_at',
        'updated_at',
    ];

    /**
     * @relationship アートに対するコメントを取得
     */
    public function art(): BelongsTo
    {
        return $this->belongsTo(Art::class);
    }

    /**
     * @relationship コメントを投稿したユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}