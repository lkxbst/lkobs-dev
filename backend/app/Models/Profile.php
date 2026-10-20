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
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'tools' => 'array',
        ];
    }

    public static function singleton(): self
    {
        /** @var self|null $profile */
        $profile = self::query()->first();

        if ($profile !== null) {
            return $profile;
        }

        return self::query()->create([
            'name' => 'Luan Kobs',
            'handle' => 'luan.kobs',
            'city' => '[sua cidade]',
            'headline' => 'Desenvolvedor de software em [sua cidade]. Construo produtos web de ponta a ponta, do banco de dados à interface, com código simples e decisões bem explicadas.',
            'headline_highlight' => 'código simples e decisões bem explicadas.',
            'is_available' => true,
            'availability_label' => 'Disponível para novos projetos',
            'about_primary' => 'Sou desenvolvedor há [X] anos e gosto de trabalhar no meio do caminho entre produto e engenharia: entender o problema, propor a solução mais simples que resolva e cuidar dos detalhes na entrega.',
            'about_secondary' => 'Hoje sou [cargo] na [empresa], onde [o que você faz no dia a dia]. Fora do trabalho, [um interesse pessoal real, como um projeto open source ou um hobby].',
            'tools' => ['TypeScript', 'React', 'Node.js', 'PostgreSQL', 'Docker'],
            'email' => '[seu@email.com]',
            'resume_path' => null,
        ]);
    }
}
