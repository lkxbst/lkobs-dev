<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\ExperienceResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SocialLinkResource;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class PortfolioPayloadService
{
    public const CACHE_KEY = 'portfolio.v1.payload';

    /**
     * @return array<string, mixed>
     */
    public function getCachedPayload(Request $request): array
    {
        /** @var array<string, mixed> $payload */
        $payload = Cache::rememberForever(
            self::CACHE_KEY,
            fn (): array => $this->buildPayload($request)
        );

        return $payload;
    }

    /**
     * @return array<string, mixed>
     */
    public function buildPayload(?Request $request = null): array
    {
        $httpRequest = $request ?? Request::create('/api/v1/portfolio', 'GET');

        $profile = Profile::singleton();
        $socialLinks = SocialLink::ordered()->get();
        $experiences = Experience::published()->ordered()->get();
        $projects = Project::published()->ordered()->get();

        $timestamps = collect([
            $profile->updated_at,
            $socialLinks->max('updated_at'),
            $experiences->max('updated_at'),
            $projects->max('updated_at'),
        ])->filter()->map(fn (mixed $date): Carbon => Carbon::parse(is_string($date) || $date instanceof \DateTimeInterface ? $date : null));

        /** @var Carbon $latestUpdate */
        $latestUpdate = $timestamps->max() ?? Carbon::now();

        $projectItems = [];
        foreach ($projects->values() as $index => $project) {
            $projectItems[] = (new ProjectResource($project, $index + 1))->toArray($httpRequest);
        }

        return [
            'profile' => (new ProfileResource($profile))->toArray($httpRequest),
            'socialLinks' => SocialLinkResource::collection($socialLinks)->resolve($httpRequest),
            'experiences' => ExperienceResource::collection($experiences)->resolve($httpRequest),
            'projects' => $projectItems,
            'updatedAt' => $latestUpdate->copy()->utc()->toIso8601String(),
        ];
    }

    public static function invalidateCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
