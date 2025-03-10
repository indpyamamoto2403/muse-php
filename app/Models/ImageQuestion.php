<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImageQuestion extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'image_path1',
        'image_path2',
        'description',
    ];

    protected $appends = [
        'image_url1',
        'image_url2',
    ];

    /**
     * 1枚目の画像URLを取得
     *
     * @return string|null
     */
    public function getImageUrl1Attribute()
    {
        if (!$this->image_path1) {
            return null;
        }

        return Storage::url($this->image_path1);
    }

    /**
     * 2枚目の画像URLを取得
     *
     * @return string|null
     */
    public function getImageUrl2Attribute()
    {
        if (!$this->image_path2) {
            return null;
        }
        
        return Storage::url($this->image_path2);
    }

    public function userSelectedImages()
    {
        return $this->hasMany(UserSelectedImage::class);
    }
}