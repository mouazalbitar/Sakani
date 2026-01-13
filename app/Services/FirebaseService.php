<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class FcmService
{
    protected static function getAccessToken()
    {
        $json = json_decode(file_get_contents(config('services.fcm.credentials')), true);

        $jwtHeader = base64_encode(json_encode(['alg' => 'RS256','typ' => 'JWT']));
        $now = time();
        $jwtClaimSet = base64_encode(json_encode([
            'iss' => $json['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => $json['token_uri'],
            'iat' => $now,
            'exp' => $now + 3600
        ]));

        // في الواقع سنستخدم مكتبة Google Auth الرسمية أو firebase/php-jwt
        // لتوقيع JWT بالـ private_key
        // ثم نرسل POST إلى $json['token_uri'] للحصول على access_token

        // لاحقًا نستخدم $accessToken في Authorization
    }

    public static function send($token, $title, $body, $data = [])
    {
        $accessToken = self::getAccessToken();

        return Http::withHeaders([
            'Authorization' => 'Bearer '.$accessToken,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/v1/projects/YOUR_PROJECT_ID/messages:send', [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body
                ],
                'data' => $data
            ]
        ]);
    }
}
