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

    /**
     * التحقق مما إذا كان الرقم مسجلاً في واتساب أم لا
     */
    public function checkPhoneExistence(string $phone): bool
    {
        // UltraMSG Contact Check API
        $response = Http::withoutVerifying()->get($this->baseUrl . 'contacts/check', [
            'token'  => $this->token,
            'chatId' => $phone . '@c.us', // الصيغة المطلوبة من UltraMSG
        ]);

        $data = $response->json();

        // إذا كانت الحالة valid أو status = valid فهذا يعني الرقم موجود
        return isset($data['status']) && $data['status'] === 'valid';
    }

    /**
     * إرسال الرسالة
     */
    public function sendMessage(string $to, string $message): array
    {
        $response = Http::asForm()->withoutVerifying()->post(
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