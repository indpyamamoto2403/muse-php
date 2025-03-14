<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    /**
     * 保存可能なカラム
     */
    protected $fillable = [
        'user_id',
        'art_id',
        'type',
        'style',
        'tradition_innovation',
        'introspective_emotional',
        'color_sense',
        'composition',
        'technique',
        'theme',
        'energy',
        'uniqueness',
    ];


    public function art()
    {
        return $this->belongsTo(Art::class);
    }
}