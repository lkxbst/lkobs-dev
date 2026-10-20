<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $handle
 * @property string $city
 * @property string $headline
 * @property string $headline_highlight
 * @property bool $is_available
 * @property string $availability_label
 * @property string $about_primary
 * @property string $about_secondary
 * @property array<int, string> $tools
 * @property string $email
 * @property string|null $resume_path
 * @property array<string, array<string, string|null>>|null $translations
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'handle',
        'city',
        'headline',
        'headline_highlight',
        'is_available',
        'availability_label',
        'about_primary',
        'about_secondary',
        'tools',
        'email',
        'resume_path',
        'translations',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'tools' => 'array',
            'translations' => 'array',
        ];
    }

    public static function singleton(): self
    {
        /** @var self|null $profile */
        $profile = self::query()->first();

        if ($profile !== null) {
            return $profile;
        }

        /** @var self $created */
        $created = self::query()->create([
            'name' => 'Luan Kobs',
            'handle' => 'luan.kobs',
            'city' => '[sua cidade]',
            'headline' => 'Desenvolvedor de software em [sua cidade]. Construo produtos web de ponta a ponta, do banco de dados à interface, com código simples e decisões bem explicadas.',
            'headline_highlight' => 'código simples e decisões bem explicadas.',
            'is_available' => true,
            'availability_label' => 'Disponível para novos projetos',
            'about_primary' => 'Sou desenvolvedor há [X] anos e trabalho no meio do caminho entre produto e engenharia: entender o problema do negócio, propor a solução mais eficiente que resolva e cuidar de cada detalhe na entrega.',
            'about_secondary' => 'Desenvolvo sistemas sob medida, plataformas SaaS, automações inteligentes e integrações com IA para empresas que precisam ganhar escala, velocidade e eficiência operacional.',
            'tools' => ['TypeScript', 'React', 'Node.js', 'PostgreSQL', 'Docker'],
            'email' => '[seu@email.com]',
            'resume_path' => null,
            'translations' => [
                'en' => [],
                'es' => [],
            ],
        ]);

        return $created;
    }
}
