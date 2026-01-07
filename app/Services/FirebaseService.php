<?php

namespace App\Services;

use Google\Auth\ApplicationDefaultCredentials;
use GuzzleHttp\Client;

class FirebaseService
{
    protected string $projectId;

    public function __construct()
    {
        $this->projectId = config('services.firebase.project_id');
    }

    public function getAccessToken(): string
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . config('services.firebase.credentials'));

        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $credentials = ApplicationDefaultCredentials::getCredentials($scopes);

        $token = $credentials->fetchAuthToken();

        return $token['access_token'];
    }

    public function sendToToken(string $token, string $title, string $body, array $data = [])
{
    $accessToken = $this->getAccessToken();

    $client = new Client();

    $response = $client->post(
        "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send",
        [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                    'data' => $data,
                ],
            ],
        ]
    );

    return json_decode($response->getBody(), true);
}
}
