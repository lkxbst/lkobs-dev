<?php

declare(strict_types=1);

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use Database\Seeders\DatabaseSeeder;

test('database seeder populates profile, social links, and projects without bracket placeholders', function (): void {
    $this->seed(DatabaseSeeder::class);

    $profile = Profile::singleton();

    expect($profile->name)->toBe('Luan Kobs')
        ->and($profile->handle)->toBe('luan.kobs')
        ->and($profile->city)->toBe('')
        ->and($profile->email)->toBe('')
        ->and($profile->is_available)->toBeTrue()
        ->and($profile->tools)->toContain('PHP', 'Laravel', 'TypeScript');

    expect(SocialLink::ordered()->count())->toBe(3)
        ->and(Experience::published()->ordered()->count())->toBe(0)
        ->and(Project::published()->ordered()->count())->toBe(1);
});

test('scopes filter unpublished items and order by sort_order', function (): void {
    Experience::factory()->create(['role' => 'Second', 'sort_order' => 2, 'is_published' => true]);
    Experience::factory()->create(['role' => 'Hidden', 'sort_order' => 1, 'is_published' => false]);
    Experience::factory()->create(['role' => 'First', 'sort_order' => 1, 'is_published' => true]);

    $roles = Experience::published()->ordered()->pluck('role')->all();

    expect($roles)->toBe(['First', 'Second']);
});
