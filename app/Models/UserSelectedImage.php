<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSelectedImage extends Model
{
    // テーブル名が "user_selected_image" であることを指定
    protected $table = 'user_selected_image';

    protected $fillable = [
        'user_id',
        'image_question_id',
        'is_former_selected',
    ];

    public function imageQuestion()
    {
        return $this->belongsTo(ImageQuestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}