<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.ultramsg.base_url');
        $this->token   = config('services.ultramsg.token');
    }

    public function sendMessage(string $to, string $message): array
    {
        $response = Http::asForm()->post( // ->withoutVerifying()
            $this->baseUrl . 'messages/chat',
            [
                'token' => $this->token,
                'to'    => $to,
                'body'  => $message,
            ]
        );

        return $response->json();
    }
}
