<?php

namespace App\Services;

use Twilio\Rest\Client;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class TwilioWhatsAppService
{
    protected $client;
    protected $twilioWhatsAppNumber;
    protected $twilioSmsNumber;
    protected $enabled = false;

    public function __construct()
    {
        $settings = Setting::whereIn('key', ['twilio_sid', 'twilio_auth_token', 'twilio_whatsapp_number', 'twilio_sms_number'])->pluck('value', 'key');
        
        $sid = $settings['twilio_sid'] ?? null;
        $token = $settings['twilio_auth_token'] ?? null;
        $this->twilioWhatsAppNumber = $settings['twilio_whatsapp_number'] ?? null;
        $this->twilioSmsNumber = $settings['twilio_sms_number'] ?? null;

        if ($sid && $token) {
            try {
                $this->client = new Client($sid, $token);
                $this->enabled = true;
            } catch (\Exception $e) {
                Log::error('Twilio Client Initialization Error: ' . $e->getMessage());
            }
        }
    }

    public function sendWhatsApp($to, $message)
    {
        if (!$this->enabled || !$this->twilioWhatsAppNumber) {
            return false;
        }

        // Ensure the 'to' number has '+' prefix if it's just numbers
        if (preg_match('/^[0-9]+$/', $to)) {
            $to = '+' . $to;
        }

        // Ensure the to number has 'whatsapp:' prefix
        if (!str_starts_with($to, 'whatsapp:')) {
            $to = 'whatsapp:' . $to;
        }

        try {
            $messageResponse = $this->client->messages->create(
                $to,
                [
                    'from' => $this->twilioWhatsAppNumber,
                    'body' => $message
                ]
            );
            return $messageResponse->sid;
        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp Send Error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendSms($to, $message)
    {
        if (!$this->enabled || !$this->twilioSmsNumber) {
            return false;
        }

        if (preg_match('/^[0-9]+$/', $to)) {
            $to = '+' . $to;
        }

        try {
            $messageResponse = $this->client->messages->create(
                $to,
                [
                    'from' => $this->twilioSmsNumber,
                    'body' => $message
                ]
            );
            return $messageResponse->sid;
        } catch (\Exception $e) {
            Log::error('Twilio SMS Send Error: ' . $e->getMessage());
            return false;
        }
    }
}
