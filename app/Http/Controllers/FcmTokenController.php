<?php

namespace App\Http\Controllers;

use App\Models\FcmToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'platform' => 'required|in:android,ios,web',
        ]);

        FcmToken::updateOrCreate(
            ['token' => $request->token],
            [
                'user_id' => Auth::user()->id,
                'platform' => $request->platform,
            ]
        );

        return response()->json(['message' => 'Token stored.']);
    }
}
