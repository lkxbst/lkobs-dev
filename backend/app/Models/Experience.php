<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ExperienceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $role
 * @property string $company
 * @property int $start_year
 * @property int|null $end_year
 * @property string $impact
 * @property array<string, array<string, string|null>>|null $translations
 * @property int $sort_order
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Experience extends Model
{
    /** @use HasFactory<ExperienceFactory> */
    use HasFactory;

    protected $fillable = [
        'role',
        'company',
        'start_year',
        'end_year',
        'impact',
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
            'start_year' => 'integer',
            'end_year' => 'integer',
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

    public static function formatPeriod(int $startYear, ?int $endYear): string
    {
        $end = $endYear !== null ? (string) $endYear : 'hoje';

        return sprintf('%d — %s', $startYear, $end);
    }

    public function formattedPeriod(): string
    {
        return self::formatPeriod($this->start_year, $this->end_year);
    }
}
