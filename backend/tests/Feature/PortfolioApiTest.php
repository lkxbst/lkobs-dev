<?php

declare(strict_types=1);

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Services\PortfolioPayloadService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

test('GET /api/v1/portfolio returns complete payload in camelCase with ETag and Last-Modified', function (): void {
    $this->seed(DatabaseSeeder::class);

    Experience::factory()->create(['sort_order' => 1, 'is_published' => true]);
    Project::factory()->create(['slug' => 'proj-2', 'sort_order' => 2, 'is_published' => true]);
    Project::factory()->create(['slug' => 'proj-3', 'sort_order' => 3, 'is_published' => true]);

    $response = $this->getJson('/api/v1/portfolio');

    $response->assertOk()
        ->assertHeader('ETag')
        ->assertHeader('Last-Modified')
        ->assertJsonStructure([
            'profile' => [
                'name',
                'handle',
                'city',
                'headline',
                'headlineHighlight',
                'isAvailable',
                'availabilityLabel',
                'about' => ['primary', 'secondary'],
                'tools',
                'email',
                'resumeUrl',
                'translations',
            ],
            'socialLinks' => [
                '*' => ['label', 'url', 'showInHero', 'showInContact'],
            ],
            'experiences' => [
                '*' => ['role', 'company', 'startYear', 'endYear', 'impact', 'translations'],
            ],
            'projects' => [
                '*' => ['number', 'name', 'slug', 'year', 'description', 'tags', 'liveUrl', 'repoUrl', 'image', 'translations'],
            ],
            'updatedAt',
        ])
        ->assertJsonPath('profile.name', 'Luan Kobs')
        ->assertJsonPath('profile.handle', 'luan.kobs')
        ->assertJsonPath('projects.0.number', '01')
        ->assertJsonPath('projects.1.number', '02')
        ->assertJsonPath('projects.2.number', '03');

    $etag = $response->headers->get('ETag');
    $notModified = $this->getJson('/api/v1/portfolio', ['If-None-Match' => (string) $etag]);
    $notModified->assertStatus(304);
});

test('GET /api/v1/portfolio filters unpublished items and orders by sort_order', function (): void {
    $this->seed(DatabaseSeeder::class);

    Experience::query()->delete();
    Project::query()->delete();

    Experience::factory()->create(['role' => 'Role B', 'sort_order' => 2, 'is_published' => true]);
    Experience::factory()->create(['role' => 'Hidden Role', 'sort_order' => 1, 'is_published' => false]);
    Experience::factory()->create(['role' => 'Role A', 'sort_order' => 1, 'is_published' => true]);

    Project::factory()->create(['name' => 'Proj B', 'slug' => 'proj-b', 'sort_order' => 2, 'is_published' => true]);
    Project::factory()->create(['name' => 'Hidden Proj', 'slug' => 'proj-hidden', 'sort_order' => 1, 'is_published' => false]);
    Project::factory()->create(['name' => 'Proj A', 'slug' => 'proj-a', 'sort_order' => 1, 'is_published' => true]);

    $response = $this->getJson('/api/v1/portfolio');

    $response->assertOk()
        ->assertJsonCount(2, 'experiences')
        ->assertJsonPath('experiences.0.role', 'Role A')
        ->assertJsonPath('experiences.1.role', 'Role B')
        ->assertJsonCount(2, 'projects')
        ->assertJsonPath('projects.0.name', 'Proj A')
        ->assertJsonPath('projects.0.number', '01')
        ->assertJsonPath('projects.1.name', 'Proj B')
        ->assertJsonPath('projects.1.number', '02');
});

test('portfolio cache is invalidated automatically when models are saved or deleted', function (): void {
    $this->seed(DatabaseSeeder::class);

    $this->getJson('/api/v1/portfolio')->assertOk();
    expect(Cache::has(PortfolioPayloadService::CACHE_KEY))->toBeTrue();

    $profile = Profile::singleton();
    $profile->update(['city' => 'Curitiba']);

    expect(Cache::has(PortfolioPayloadService::CACHE_KEY))->toBeFalse();

    $response = $this->getJson('/api/v1/portfolio');
    $response->assertOk()->assertJsonPath('profile.city', 'Curitiba');
    expect(Cache::has(PortfolioPayloadService::CACHE_KEY))->toBeTrue();

    $project = Project::query()->firstOrFail();
    $project->delete();

    expect(Cache::has(PortfolioPayloadService::CACHE_KEY))->toBeFalse();
});

test('GET /cv returns 404 when no resume is uploaded and serves inline PDF when present', function (): void {
    Storage::fake('public');
    $this->seed(DatabaseSeeder::class);

    $this->get('/cv')->assertNotFound();

    Storage::disk('public')->put('resumes/cv.pdf', '%PDF-1.4 fake pdf content');
    $profile = Profile::singleton();
    $profile->update(['resume_path' => 'resumes/cv.pdf']);

    $apiResponse = $this->getJson('/api/v1/portfolio');
    $apiResponse->assertOk()->assertJsonPath('profile.resumeUrl', url('/cv'));

    $cvResponse = $this->get('/cv');
    $cvResponse->assertOk()
        ->assertHeader('Content-Type', 'application/pdf')
        ->assertHeader('Content-Disposition', 'inline; filename="luan.kobs.pdf"');
});

test('project image upload is automatically converted to WebP and scaled down to max 1600px width', function (): void {
    Storage::fake('public');
    $this->seed(DatabaseSeeder::class);
    $project = Project::query()->firstOrFail();

    $uploaded = UploadedFile::fake()->image('screenshot.png', 2000, 1250);
    Storage::disk('public')->putFileAs('projects', $uploaded, 'screenshot.png');

    $project->update([
        'image_path' => 'projects/screenshot.png',
        'image_alt' => 'Screenshot do projeto',
    ]);

    $project->refresh();

    expect($project->image_path)->toBe('projects/screenshot.webp')
        ->and($project->image_width)->toBe(1600)
        ->and($project->image_height)->toBe(1000)
        ->and(Storage::disk('public')->exists('projects/screenshot.webp'))->toBeTrue();

    $response = $this->getJson('/api/v1/portfolio');
    $response->assertOk()
        ->assertJsonPath('projects.0.image.alt', 'Screenshot do projeto')
        ->assertJsonPath('projects.0.image.width', 1600)
        ->assertJsonPath('projects.0.image.height', 1000);
});

test('rate limiter blocks after 60 requests per minute', function (): void {
    $this->seed(DatabaseSeeder::class);

    for ($i = 0; $i < 60; $i++) {
        $this->getJson('/api/v1/portfolio')->assertOk();
    }

    $this->getJson('/api/v1/portfolio')->assertStatus(429);
});

test('contract between /api/v1/portfolio and frontend/src/data/portfolio.fixture.json matches', function (): void {
    $this->seed(DatabaseSeeder::class);

    $fixturePath = base_path('../frontend/src/data/portfolio.fixture.json');
    $this->artisan('app:export-fixture', ['--path' => $fixturePath])->assertSuccessful();

    expect(File::exists($fixturePath))->toBeTrue();

    /** @var array<string, mixed> $fixture */
    $fixture = json_decode((string) File::get($fixturePath), true);

    /** @var array<string, mixed> $apiPayload */
    $apiPayload = $this->getJson('/api/v1/portfolio')->assertOk()->json();

    expect(array_keys($apiPayload))->toBe(array_keys($fixture))
        ->and(array_keys((array) $apiPayload['profile']))->toBe(array_keys((array) $fixture['profile']))
        ->and(array_keys((array) $apiPayload['socialLinks'][0]))->toBe(array_keys((array) $fixture['socialLinks'][0]))
        ->and(array_keys((array) $apiPayload['projects'][0]))->toBe(array_keys((array) $fixture['projects'][0]))
        ->and($apiPayload['profile'])->toEqual($fixture['profile'])
        ->and($apiPayload['socialLinks'])->toEqual($fixture['socialLinks'])
        ->and($apiPayload['experiences'])->toEqual($fixture['experiences'])
        ->and($apiPayload['projects'])->toEqual($fixture['projects']);
});
