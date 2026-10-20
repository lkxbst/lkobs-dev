<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:portfolio')->prefix('v1')->group(function (): void {
    Route::get('/portfolio', PortfolioController::class)->name('api.v1.portfolio');
});
