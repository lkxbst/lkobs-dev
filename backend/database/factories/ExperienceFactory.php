<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role' => '[Cargo]',
            'company' => '[Empresa]',
            'start_year' => 2023,
            'end_year' => null,
            'impact' => '[Uma linha sobre o impacto: o que você construiu, melhorou ou liderou.]',
            'sort_order' => 1,
            'is_published' => true,
        ];
    }
}
