<?php

declare(strict_types=1);

use App\Http\Controllers\ResumeController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn (): RedirectResponse => redirect('/admin'));

Route::get('/cv', ResumeController::class)
    ->middleware('throttle:portfolio')
    ->name('resume.show');
