<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        return asset('storage/' . $this->image);
    }

    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}