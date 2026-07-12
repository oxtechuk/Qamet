<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Services\TwilioWhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppCampaignMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 5;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $leadId,
        public string $message,
    ) {
        $this->onQueue('whatsapp');

    }

    /**
     * Execute the job.
     */
    public function handle(TwilioWhatsAppService $whatsapp): void
    {
        $lead = Lead::find($this->leadId);

        if (! $lead || ! $lead->client_phone) {
            Log::warning("WhatsApp Campaign: Lead {$this->leadId} not found or has no phone.");

            return;
        }

        $message = str_replace(
            ['{name}', '{phone}'],
            [$lead->client_name, $lead->client_phone ?? ''],
            $this->message,
        );

        $result = $whatsapp->sendWhatsApp($lead->client_phone, $message);

        if ($result) {
            Log::info("WhatsApp Campaign: Message sent to lead {$this->lead->id} ({$lead->client_phone})");
        } else {
            Log::error("WhatsApp Campaign: Failed to send to lead {$this->lead->id} ({$lead->client_phone})");
            $this->fail(new \Exception("Failed to send WhatsApp to lead {$this->leadId}"));
        }
    }
}
