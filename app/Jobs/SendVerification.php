<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumber;
    protected $verificationCode;

    public function __construct(string $phoneNumber, string $verificationCode)
    {
        $this->phoneNumber = $phoneNumber;
        $this->verificationCode = $verificationCode;
    }

    public function handle(): void
    {

        $instanceId = env('ULTRAMSG_INSTANCE_ID');
    $token = env('ULTRAMSG_TOKEN');
    $apiUrl = env('ULTRAMSG_API_URL');
    
    // التأكد من أن جميع المتغيرات موجودة قبل المتابعة
    if (empty($instanceId) || empty($token) || empty($apiUrl)) {
        Log::error('ULTRAMSG environment variables are missing.');
        return; // إيقاف التنفيذ لتجنب الفشل غير المبرر
    }

    $url = "{$apiUrl}/{$instanceId}/messages/chat";

    $messageBody = 'Hi, Thanks for registered in our application. Your Verification Code is ' . $this->verificationCode;

    $response = Http::asForm()->post($url, [ // استخدام asForm لضمان التوافق مع UltraMsg
        'token' => $token,
        'to' => $this->phoneNumber,
        'body' => $messageBody
    ]);
        // معالجة الأخطاء (ضروري في الـ Job)
        if ($response->failed()) {
            // تسجيل الخطأ كاملاً في سجلات Laravel
            Log::error('UltraMsg Failed:', [
                'status' => $response->status(),
                'response_body' => $response->body(),
                'phone' => $this->phoneNumber
            ]);
            // إطلاق استثناء لإجبار Laravel على إعادة المحاولة أو تسجيل الفشل في جدول failed_jobs
            throw new \Exception("UltraMsg API call failed: " . $response->body());
        }
    }
}