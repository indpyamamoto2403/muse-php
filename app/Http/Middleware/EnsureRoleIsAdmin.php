<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleIsAdmin
{
    /**
     * アーティストのロールを持っているか確認し、そうでなければ403エラーを返す。
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ユーザーが認証済みで、かつroleが'admin'であるか確認
        if (!$request->user() || $request->user()->role !== 'admin') {
            abort(403, 'アクセス権限がありません。');
        }
        return $next($request);
    }
}