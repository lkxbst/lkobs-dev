<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $year
 * @property string $description
 * @property array<int, string> $tags
 * @property string|null $live_url
 * @property string|null $repo_url
 * @property string|null $image_path
 * @property string|null $image_alt
 * @property int|null $image_width
 * @property int|null $image_height
 * @property array<string, array<string, string|null>>|null $translations
 * @property int $sort_order
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'year',
        'description',
        'tags',
        'live_url',
        'repo_url',
        'image_path',
        'image_alt',
        'image_width',
        'image_height',
        'translations',
        'sort_order',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'tags' => 'array',
            'image_width' => 'integer',
            'image_height' => 'integer',
            'translations' => 'array',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public static function formatNumber(int $position): string
    {
        return str_pad((string) $position, 2, '0', STR_PAD_LEFT);
    }
}
