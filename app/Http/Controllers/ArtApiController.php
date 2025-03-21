<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArtApiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class ArtApiController extends Controller
{
    private $artApiService;
    private $userId;

    public function __construct(ArtApiService $artApiService)
    {
        $this->artApiService = $artApiService;
        $this->userId = Auth::id();
    }
    

    public function like(Request $request)
    {
        if($request->isLiked){
            $this->artApiService->like($request->artId, $this->userId);
        }else{
            $this->artApiService->unlike($request->artId, $this->userId);
        }

        return response()->json(['message' => $request->is_like ? 'いいねしました' : 'いいねを取り消しました']);
    }

    public function save(Request $request)
    {
        if($request->isSaved){
            $this->artApiService->save($request->artId, $this->userId);
        }else{
            $this->artApiService->unsave($request->artId, $this->userId);
        }

        return response()->json(['message' => $request->is_save ? '保存しました' : '保存を取り消しました']);
    }

    public function comment(Request $request)
    {
        $this->artApiService->comment($request->artId, $request->comment);
        return response()->json(['message' => 'コメントしました']);
    }

    public function updateComment(Request $request, $id)
    {
        $this->artApiService->updateComment($id, $request->comment);
        return response()->json(['message' => 'コメントを更新しました']);
    }

    public function deleteComment(Request $request, $id)
    {
        $this->artApiService->deleteComment($id);
        return response()->json(['message' => 'コメントを削除しました']);
    }
}
