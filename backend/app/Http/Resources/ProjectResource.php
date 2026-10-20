<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Project
 */
class ProjectResource extends JsonResource
{
    public function __construct(
        Project $resource,
        private readonly int $position = 1,
    ) {
        parent::__construct($resource);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = null;
        $imagePath = $this->image_path;

        if ($imagePath !== null && $imagePath !== '' && Storage::disk('public')->exists($imagePath)) {
            $image = [
                'url' => url(Storage::disk('public')->url($imagePath)),
                'alt' => $this->image_alt ?? $this->name,
                'width' => $this->image_width ?? 1600,
                'height' => $this->image_height ?? 1000,
            ];
        }

        return [
            'number' => Project::formatNumber($this->position),
            'name' => $this->name,
            'slug' => $this->slug,
            'year' => (int) $this->year,
            'description' => $this->description,
            'tags' => array_values($this->tags),
            'liveUrl' => $this->live_url,
            'repoUrl' => $this->repo_url,
            'image' => $image,
        ];
    }
}
