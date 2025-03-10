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
class ImageQuestionController extends Controller
{
    /**
     * 画像一覧画面の表示
     */
    public function register()
    {
        // 登録されているすべての画像情報を取得
        $images = ImageQuestion::all() ?? [];

        // Inertia を使って Vue コンポーネント 'Questions/ImageRegister' にデータを渡す
        return Inertia::render('Questions/ImageRegister', [
            'images' => $images,
        ]);
    }

    /**
     * 画像2枚と説明のアップロード処理
     */
    public function upload(Request $request)
    {
        Log::debug($request->all());
        // リクエストの検証（説明は必須、画像はそれぞれ画像ファイルで最大2MB）
        $validated = $request->validate([
            'description' => 'required|string',
            'image1' => 'required|image|max:2048',
            'image2' => 'required|image|max:2048',
        ]);

        // 一意なUUIDを生成（例: "a1b2c3d4-..."）
        $uuid = (string) Str::uuid();

        // 保存先のディレクトリ（例: "questions/{uuid}"）
        $folder = "questions/{$uuid}";

        // 画像ファイルを storage/app/public/questions/{uuid} に保存（ファイル名は 1.png, 2.png）
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
        // 登録されているすべての画像情報を取得
        $images = ImageQuestion::all() ?? [];
        // Inertia を使って Vue コンポーネント 'Questions/ImageRegister' にデータを渡す
        return Inertia::render('Questions/ImageAnswer', [
            'images' => $images,
        ]);
    }

    public function answerStore(Request $request)
    {

    
        try {
            DB::beginTransaction();
    
            foreach ($request->selections as $selection) {
                // 明示的に各フィールドを指定して作成

                Log::debug($selection);
                UserSelectedImage::create([
                    'user_id' => Auth::id(),
                    'image_question_id' => $selection['image_question_id'],
                    'is_former_selected' => $selection['is_former_selected'],
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('questions.image.answer')
                ->with('success', 'すべての回答を保存しました');
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('回答保存エラー: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', '回答の保存中にエラーが発生しました');
        }
    }
}
