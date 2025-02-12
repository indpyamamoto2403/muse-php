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
}