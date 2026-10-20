<?php

declare(strict_types=1);

use App\Models\Experience;
use App\Models\Project;

test('project formatNumber pads single digits with leading zero', function (): void {
    expect(Project::formatNumber(1))->toBe('01')
        ->and(Project::formatNumber(9))->toBe('09')
        ->and(Project::formatNumber(10))->toBe('10')
        ->and(Project::formatNumber(25))->toBe('25');
});

test('experience formatPeriod formats open and closed date ranges', function (): void {
    expect(Experience::formatPeriod(2023, null))->toBe('2023 — hoje')
        ->and(Experience::formatPeriod(2021, 2023))->toBe('2021 — 2023');
});
