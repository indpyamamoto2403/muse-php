<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckEvaluationExists
{
    public function handle(Request $request, Closure $next)
    {
        // ユーザーがログインしているか確認
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // evaluations テーブルにログインユーザーのレコードが存在するか確認
        $exists = DB::table('evaluations')
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            //ダッシュボードにリダイレクト
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
