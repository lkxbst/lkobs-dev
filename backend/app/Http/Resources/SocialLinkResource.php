<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SocialLink
 */
class SocialLinkResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'label' => $this->label,
            'url' => $this->url,
            'showInHero' => (bool) $this->show_in_hero,
            'showInContact' => (bool) $this->show_in_contact,
        ];
    }
}
