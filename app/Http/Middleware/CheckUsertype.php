<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUsertype
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. التحقق من المصادقة (Auth::check()):
        // يجب أن يسبق هذا الـ Middleware، ولكن التحقق هنا يزيد الأمان.
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = Auth::user();

        // 2. التحقق من الدور (Authorization):
        // نفترض أن حقل 'type' أو 'role' يجب أن يساوي 'admin'
        if ($user->type == 1) {
            return $next($request);
        }
        
        // 3. منع الوصول والرد بـ 403
        return response()->json(['message' => 'Access denied. Just for Admin.'], 403);
    }
}
