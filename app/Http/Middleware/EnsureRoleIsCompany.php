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
        // ユーザーが認証済みで、かつroleが'company'または'admin'もしくはであるか確認
        if (!$request->user() || !in_array($request->user()->role, ['company', 'admin'])) {
            abort(403, 'アクセス権限がありません。');
        }
        return $next($request);
    }
}
