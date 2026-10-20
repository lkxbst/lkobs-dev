<?php

declare(strict_types=1);

use App\Filament\Resources\Experiences\Pages\CreateExperience;
use App\Filament\Resources\Profiles\Pages\EditProfile;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\SocialLinks\Pages\ListSocialLinks;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

test('unauthenticated requests to /admin redirect to login page', function (): void {
    $this->get('/admin')->assertRedirect('/admin/login');
});

test('non-admin user cannot access /admin panel', function (): void {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

test('app:create-admin command creates an admin user', function (): void {
    $this->artisan('app:create-admin', [
        '--name' => 'Luan Kobs',
        '--email' => 'admin@kobs.dev',
        '--password' => 'secret1234',
    ])->assertSuccessful();

    $user = User::query()->where('email', 'admin@kobs.dev')->first();

    expect($user)->not->toBeNull()
        ->and($user?->is_admin)->toBeTrue()
        ->and(Hash::check('secret1234', (string) $user?->password))->toBeTrue();
});

test('admin can edit singleton profile and changes reflect immediately in /api/v1/portfolio', function (): void {
    $this->seed(DatabaseSeeder::class);

    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    // Warm up cache first
    $this->getJson('/api/v1/portfolio')
        ->assertOk()
        ->assertJsonPath('profile.city', '');

    Livewire::test(EditProfile::class)
        ->fillForm([
            'city' => 'Joinville, SC',
            'email' => 'luan@kobs.dev',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->getJson('/api/v1/portfolio')
        ->assertOk()
        ->assertJsonPath('profile.city', 'Joinville, SC')
        ->assertJsonPath('profile.email', 'luan@kobs.dev');
});

test('admin can edit project, create experience, and trigger manual publish action', function (): void {
    $this->seed(DatabaseSeeder::class);

    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $project = Project::query()->firstOrFail();

    Livewire::test(EditProject::class, ['record' => $project->getKey()])
        ->fillForm([
            'name' => 'Kobs API Gateway',
            'year' => 2026,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    Livewire::test(CreateExperience::class)
        ->fillForm([
            'role' => 'Senior Backend Engineer',
            'company' => 'Kobs Dev',
            'start_year' => 2024,
            'end_year' => null,
            'impact' => 'Arquitetura de microsserviços em PHP 8.2 e Laravel.',
            'sort_order' => 0,
            'is_published' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    Livewire::test(ListSocialLinks::class)
        ->callAction('publishSite')
        ->assertNotified();

    $this->getJson('/api/v1/portfolio')
        ->assertOk()
        ->assertJsonPath('projects.0.name', 'Kobs API Gateway')
        ->assertJsonPath('experiences.0.role', 'Senior Backend Engineer');
});
