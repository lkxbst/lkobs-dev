<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SocialLinkFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $label
 * @property string $url
 * @property bool $show_in_hero
 * @property bool $show_in_contact
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class SocialLink extends Model
{
    /** @use HasFactory<SocialLinkFactory> */
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'show_in_hero',
        'show_in_contact',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'show_in_hero' => 'boolean',
            'show_in_contact' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
