<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
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
        ];
    }
}
