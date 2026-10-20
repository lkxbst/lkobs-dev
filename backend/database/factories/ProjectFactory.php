<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => '[Nome do projeto]',
            'slug' => 'projeto-'.fake()->unique()->slug(2),
            'year' => 2025,
            'description' => '[O problema que ele resolve e o que você construiu, em duas frases. Se tiver um resultado concreto, cite aqui.]',
            'tags' => ['[React]', '[Node.js]', '[PostgreSQL]'],
            'live_url' => 'https://example.com',
            'repo_url' => 'https://github.com/luankobs/projeto',
            'image_path' => null,
            'image_alt' => null,
            'image_width' => null,
            'image_height' => null,
            'sort_order' => 1,
            'is_published' => true,
        ];
    }
}
