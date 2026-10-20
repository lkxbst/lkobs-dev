<?php

declare(strict_types=1);

use App\Jobs\TriggerFrontendRebuild;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

test('TriggerFrontendRebuild posts to deploy webhook URL when configured', function (): void {
    Http::fake([
        'https://api.cloudflare.com/client/v4/pages/webhooks/*' => Http::response(['success' => true], 200),
    ]);

    config()->set('services.frontend.deploy_webhook_url', 'https://api.cloudflare.com/client/v4/pages/webhooks/deploy_hook/123');
    config()->set('services.frontend.github_dispatch_repo', '');
    config()->set('services.frontend.github_dispatch_token', '');

    $job = new TriggerFrontendRebuild('test_webhook');
    expect($job->uniqueId())->toBe('trigger-frontend-rebuild');

    $job->handle();

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://api.cloudflare.com/client/v4/pages/webhooks/deploy_hook/123'
            && $request['reason'] === 'test_webhook';
    });
});

test('TriggerFrontendRebuild triggers GitHub repository_dispatch when repo and token are configured', function (): void {
    Http::fake([
        'https://api.github.com/repos/luankobs/kobs-dev/dispatches' => Http::response('', 204),
    ]);

    config()->set('services.frontend.deploy_webhook_url', '');
    config()->set('services.frontend.github_dispatch_repo', 'luankobs/kobs-dev');
    config()->set('services.frontend.github_dispatch_token', 'ghp_test_token');

    $job = new TriggerFrontendRebuild('model_saved:Project');
    $job->handle();

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://api.github.com/repos/luankobs/kobs-dev/dispatches'
            && $request['event_type'] === 'portfolio-rebuild'
            && $request['client_payload']['reason'] === 'model_saved:Project';
    });
});
