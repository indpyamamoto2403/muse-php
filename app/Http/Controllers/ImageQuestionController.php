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

        // 保存先のディレクトリ（例: "questions/{uuid}"）
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

        // 画像一覧画面にリダイレクトし、成功メッセージをフラッシュ
        return redirect()->route('questions.image.register')->with('success', 'Image uploaded successfully.');
    }

    /**
     * 画像削除処理
     */
    public function destroy($id)
    {
        // 指定された ID の画像情報を取得、存在しない場合は 404 エラー
        $imageQuestion = ImageQuestion::findOrFail($id);

        // ストレージ上に画像ファイルが存在すれば削除
        if (Storage::disk('public')->exists($imageQuestion->path)) {
            Storage::disk('public')->delete($imageQuestion->path);
        }

        // データベースからもレコードを削除
        $imageQuestion->delete();

        // 画像一覧画面にリダイレクトし、削除完了メッセージをフラッシュ
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
     * 回答を貯蓄する
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
