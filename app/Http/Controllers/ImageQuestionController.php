<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ImageQuestion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\UserSelectedImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ImageQuestionService;
class ImageQuestionController extends Controller
{
    private $imageQuestionService;
    public function __construct(ImageQuestionService $imageQuestionService)
    {
        $this->imageQuestionService = $imageQuestionService;
    }
    /**
     * 画像一覧画面の表示
     */
    public function register()
    {
        return Inertia::render('Questions/ImageRegister', [
        ]);
    }

    /**
     * 画像2枚と説明のアップロード処理
     */
    public function upload(Request $request)
    {

        $uuid = (string) Str::uuid();

        // directory（例: "questions/{uuid}"）
        $folder = "questions/{$uuid}";

        $image1Path = $request->file('image1')->storeAs($folder, '1.png', 'public');
        $image2Path = $request->file('image2')->storeAs($folder, '2.png', 'public');

        // ※テーブルに 'uuid', 'description', 'image1', 'image2' などのカラムが存在することを前提
        ImageQuestion::create([
            'id'        => $uuid,
            'description' => $request->input('description'),
            'image_path1'      => $image1Path,
            'image_path2'      => $image2Path,
        ]);

        // redirect to the image list page and flash the success message
        return redirect()->route('questions.image.register')->with('success', 'Image uploaded successfully.');
    }

    /**
     * 画像削除処理
     */
    public function destroy($id)
    {
        // get the information about image , which is going to be deleted
        $imageQuestion = ImageQuestion::findOrFail($id);

        // delete if the image is in public disk
        if (Storage::disk('public')->exists($imageQuestion->path)) {
            Storage::disk('public')->delete($imageQuestion->path);
        }

        // delete the image from the database
        $imageQuestion->delete();

        //redirect to the image list page and flash the success message
        return redirect()->route('questions.image.index')->with('success', 'Image deleted successfully.');
    }

    public function answer()
    {
        $images = $this->imageQuestionService->getRandomChoice(5);
        return Inertia::render('Questions/ImageAnswer', [
            'images' => $images,
        ]);
    }

    /**
     * store the answers into Database
     */
    public function answerStore(Request $request)
    {
        $isSucceed = $this->imageQuestionService->storeAnswer($request);
        if ($isSucceed) {
            return redirect()->route('questions.image.answer')->with('success', '回答が保存されました。');
        } else {
            return redirect()->route('questions.image.answer')->with('error', '回答の保存に失敗しました。');
        }
    }
}
