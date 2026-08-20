<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\Tracking\ConversionApiService;
use Illuminate\Foundation\Queue\Queueable;

class SendConversionEventJob
{
    use Queueable;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        public array $payload
    ) {}

    public function handle(ConversionApiService $service): void
    {
        $service->sendLeadEvent($this->payload);
    }
}
