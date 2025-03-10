<?php

namespace App\Repositories;
use App\Models\ImageQuestion;

class ImageQuestionRepository
{
    public function getImages()
    {
        // 登録されているすべての画像情報を取得
        $images = ImageQuestion::all() ?? [];

        return $images;
    }

    /**
     * 引数の数だけ渡す、そして得るレコードはランダム
     */
    public function getRandomChoice(int $num)
    {
        return ImageQuestion::inRandomOrder()->take($num)->get();
    }
}