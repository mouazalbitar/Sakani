<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApprovedUser
{
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::attempt($request->only('phone_number', 'password')))
        //     return response()->json([
        //         'message' => 'Login Failed, Incorrect Phone Number or Password.'
        //     ], 404);



        // if (!User::where('phone_number', $request->phone_number))
        //     return response()->json([
        //         'message' => 'Login Failed, Incorrect Phone Number or Password.',
        //     ], 401);
        // $user = User::where('phone_number', $request->phone_number)->firstOrFail();
        // if ($user->is_approved == 1)
            return $next($request);
        // return response()->json(['message' => 'User not approved yet.'], 403);
    }
}
