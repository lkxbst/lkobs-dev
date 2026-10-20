<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Experience
 */
class ExperienceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'role' => $this->role,
            'company' => $this->company,
            'startYear' => (int) $this->start_year,
            'endYear' => $this->end_year !== null ? (int) $this->end_year : null,
            'impact' => $this->impact,
            'translations' => [
                'en' => (object) ($this->translations['en'] ?? []),
                'es' => (object) ($this->translations['es'] ?? []),
            ],
        ];
    }
}
