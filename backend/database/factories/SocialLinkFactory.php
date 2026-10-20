<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialLink>
 */
class SocialLinkFactory extends Factory
{
    protected $model = SocialLink::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => 'GitHub',
            'url' => 'https://github.com/luankobs',
            'show_in_hero' => true,
            'show_in_contact' => true,
            'sort_order' => 1,
        ];
    }
}
