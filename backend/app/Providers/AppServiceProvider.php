<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use App\Observers\PortfolioCacheObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('portfolio', function (Request $request): Limit {
            return Limit::perMinute(60)->by((string) $request->ip());
        });

        Profile::observe(PortfolioCacheObserver::class);
        SocialLink::observe(PortfolioCacheObserver::class);
        Experience::observe(PortfolioCacheObserver::class);
        Project::observe(PortfolioCacheObserver::class);
    }
}
