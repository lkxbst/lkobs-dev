<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TriggerFrontendRebuild implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public int $uniqueFor = 60;

    public function __construct(
        public readonly string $reason = 'content_updated',
    ) {}

    public function uniqueId(): string
    {
        return 'trigger-frontend-rebuild';
    }

    public function handle(): void
    {
        $webhookUrl = (string) config('services.frontend.deploy_webhook_url', '');
        $githubRepo = (string) config('services.frontend.github_dispatch_repo', '');
        $githubToken = (string) config('services.frontend.github_dispatch_token', '');

        if ($webhookUrl !== '') {
            $response = Http::timeout(15)->post($webhookUrl, [
                'reason' => $this->reason,
                'triggered_at' => now()->toIso8601String(),
            ]);

            Log::info('Frontend rebuild webhook triggered.', [
                'reason' => $this->reason,
                'status' => $response->status(),
                'successful' => $response->successful(),
            ]);

            return;
        }

        if ($githubRepo !== '' && $githubToken !== '') {
            $response = Http::timeout(15)
                ->withToken($githubToken)
                ->withHeaders(['Accept' => 'application/vnd.github+json'])
                ->post("https://api.github.com/repos/{$githubRepo}/dispatches", [
                    'event_type' => 'portfolio-rebuild',
                    'client_payload' => [
                        'reason' => $this->reason,
                        'triggered_at' => now()->toIso8601String(),
                    ],
                ]);

            Log::info('Frontend rebuild GitHub repository_dispatch triggered.', [
                'reason' => $this->reason,
                'repo' => $githubRepo,
                'status' => $response->status(),
                'successful' => $response->successful(),
            ]);

            return;
        }

        Log::info('Frontend rebuild requested (no external webhook configured yet).', [
            'reason' => $this->reason,
            'triggered_at' => now()->toIso8601String(),
        ]);
    }
}
