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
        // بناء رسالة التحقق
        $messageBody = "مرحباً! رمز التحقق الخاص بك هو: " . $this->verificationCode . ". يُرجى استخدامه لتأكيد الحساب.";
        
        // بناء الـ URL الكامل باستخدام متغيرات البيئة
        $url = env('ULTRAMSG_API_URL') . '/' . env('ULTRAMSG_INSTANCE_ID') . '/messages/chat';

        // استخدام Http::asForm() لإرسال البيانات كتنسيق application/x-www-form-urlencoded
        // هذه الطريقة هي المكافئ الحديث والأسهل لاستخدام cURL مع POSTFIELDS و Content-Type
        $response = Http::asForm()->post($url, [
            'token' => env('ULTRAMSG_TOKEN'),
            // رقم الهاتف يجب أن يتضمن رمز الدولة، على سبيل المثال: +963xxxxxxxxx
            'to'    => $this->phoneNumber, 
            'body'  => $messageBody,
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