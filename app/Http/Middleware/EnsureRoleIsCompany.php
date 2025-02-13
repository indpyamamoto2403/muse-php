<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleIsCompany
{
    /**
     * Handle an incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ユーザーが認証済みで、かつroleが'company'であるか確認
        if (!$request->user() || $request->user()->role !== 'company') {
            abort(403, 'アクセス権限がありません。');
        }
        return $next($request);
    }
}
