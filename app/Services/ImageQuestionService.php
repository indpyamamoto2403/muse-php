<?php

namespace App\Services;

use App\Repositories\ImageQuestionRepository;
use Illuminate\Http\Request;
use App\Models\UserSelectedImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImageQuestionService
{
    private $imageQuestionRepository;
    public function __construct(ImageQuestionRepository $imageQuestionRepository)
    {
        $this->imageQuestionRepository = $imageQuestionRepository;
    }
    public function getImages()
    {
        return $this->imageQuestionRepository->getImages();
    }

    public function getRandomChoice(int $num)
    {
        return $this->imageQuestionRepository->getRandomChoice($num);
    }

    public function storeAnswer(Request $request) :bool
    {
        DB::beginTransaction();
    
        try {
            foreach ($request->selections as $selection) {
                // 明示的に各フィールドを指定して作成

        UserSelectedImage::create([
            'user_id' => Auth::id(),
            'image_question_id' => $selection['image_question_id'],
            'is_former_selected' => $selection['is_former_selected'],
            ]);
        }
    
        DB::commit();
        return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('回答保存エラー: ' . $e->getMessage());
            return false;
        }
    }
}