<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;

class TwilioOtpService
{
    protected ?Client $client = null;

    protected ?string $from = null;

    protected int $otpLength;

    protected int $ttlMinutes;

    public function __construct()
    {
        $this->from = config('twilio.from_number');
        $this->otpLength = (int) config('twilio.otp_length', 6);
        $this->ttlMinutes = (int) config('twilio.otp_ttl_minutes', 5);
    }

    protected function ensureClient(): void
    {
        if ($this->client !== null) {
            return;
        }

        $sid = config('twilio.account_sid');
        $token = config('twilio.auth_token');

        $this->client = new Client($sid, $token);
    }

    /**
     * توليد وإرسال OTP لرقم الجوال.
     * يخزّن الكود في الـ session مع وقت الانتهاء.
     *
     * @param  string  $phone  رقم الجوال (مثال: 0512345678 أو +966512345678)
     * @return array ['success' => bool, 'message' => string]
     */
    public function sendOtp(string $phone): array
    {
        try {
            $this->ensureClient();

            $code = $this->generateCode();

            // حفظ الكود في session مع hash للتأمين
            Session::put('otp_data', [
                'code' => hash('sha256', $code),
                'phone' => $phone,
                'expires_at' => now()->addMinutes($this->ttlMinutes)->timestamp,
            ]);

            // إرسال SMS
            $message = __('رمز التحقق الخاص بك هو: :code\nصالح لمدة :minutes دقائق.', [
                'code' => $code,
                'minutes' => $this->ttlMinutes,
            ]);

            $this->client->messages->create(
                $this->normalizePhone($phone),
                [
                    'from' => $this->from,
                    'body' => $message,
                ]
            );

            return ['success' => true, 'message' => __('تم إرسال رمز التحقق إلى جوالك')];
        } catch (\Throwable $e) {
            Log::error('Twilio OTP send error: '.$e->getMessage(), [
                'phone' => $phone,
            ]);

            return ['success' => false, 'message' => __('فشل إرسال رمز التحقق، تحقق من رقم الجوال وحاول مرة أخرى')];
        }
    }

    /**
     * التحقق من صحة كود OTP.
     *
     * @return array ['success' => bool, 'message' => string]
     */
    public function verifyOtp(string $phone, string $code): array
    {
        $data = Session::get('otp_data');

        if (! $data) {
            return ['success' => false, 'message' => __('لم يتم إرسال رمز التحقق، أعد المحاولة')];
        }

        // التحقق من رقم الهاتف
        if ($data['phone'] !== $phone) {
            return ['success' => false, 'message' => __('رقم الجوال غير مطابق')];
        }

        // التحقق من انتهاء الصلاحية
        if (now()->timestamp > $data['expires_at']) {
            Session::forget('otp_data');

            return ['success' => false, 'message' => __('انتهت صلاحية رمز التحقق، أعد الإرسال'), 'expired' => true];
        }

        // التحقق من الكود
        if (! hash_equals($data['code'], hash('sha256', trim($code)))) {
            return ['success' => false, 'message' => __('رمز التحقق غير صحيح')];
        }

        // حذف الكود بعد التحقق (يمنع إعادة الاستخدام)
        Session::forget('otp_data');

        return ['success' => true, 'message' => __('تم التحقق بنجاح')];
    }

    /**
     * توليد كود عشوائي بالطول المحدد.
     */
    private function generateCode(): string
    {
        $min = (int) str_pad('1', $this->otpLength, '0');
        $max = (int) str_pad('', $this->otpLength, '9');

        return str_pad(random_int($min, $max), $this->otpLength, '0', STR_PAD_LEFT);
    }

    /**
     * تحويل رقم الجوال إلى صيغة دولية إذا لم يكن كذلك.
     * يفترض أرقام السعودية افتراضياً.
     */
    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\s+/', '', $phone);

        if (str_starts_with($phone, '+')) {
            return $phone;
        }

        // إزالة الصفر الأمامي وإضافة كود السعودية
        if (str_starts_with($phone, '0')) {
            return '+966'.substr($phone, 1);
        }

        return '+966'.$phone;
    }
}
