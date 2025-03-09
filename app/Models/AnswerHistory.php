<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AnswerHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'answer_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
    ];

    /**
     * Get the user that owns the answer history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that owns the answer history.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

        /**
     * Interact with the answer attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function answer(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value, // アクセサはそのまま
            set: function ($value) {
                return match ($value) {
                    1 => 'yes',
                    -1 => 'no',
                    0 => 'not_answered',
                    // 文字列で来た場合の対応
                    'yes' => 'yes',
                    'no' => 'no',
                    'not_answered' => 'not_answered',
                    default => throw new \InvalidArgumentException("Invalid answer value: $value"),
                };
            },
        );
    }
}