<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Profile
 */
class ProfileResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $hasResume = $this->resume_path !== null
            && $this->resume_path !== ''
            && Storage::disk('public')->exists($this->resume_path);

        return [
            'name' => $this->name,
            'handle' => $this->handle,
            'city' => $this->city,
            'headline' => $this->headline,
            'headlineHighlight' => $this->headline_highlight,
            'isAvailable' => (bool) $this->is_available,
            'availabilityLabel' => $this->availability_label,
            'about' => [
                'primary' => $this->about_primary,
                'secondary' => $this->about_secondary,
            ],
            'tools' => array_values($this->tools),
            'email' => $this->email,
            'resumeUrl' => $hasResume ? url('/cv') : null,
            'translations' => [
                'en' => (object) ($this->translations['en'] ?? []),
                'es' => (object) ($this->translations['es'] ?? []),
            ],
        ];
    }
}
