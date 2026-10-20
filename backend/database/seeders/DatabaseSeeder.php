<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Profile::query()->delete();
        SocialLink::query()->delete();
        Experience::query()->delete();
        Project::query()->delete();

        Profile::query()->create([
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

        SocialLink::query()->create([
            'label' => 'GitHub',
            'url' => 'https://github.com/lkxbst',
            'show_in_hero' => true,
            'show_in_contact' => true,
            'sort_order' => 1,
        ]);

        SocialLink::query()->create([
            'label' => 'LinkedIn',
            'url' => 'https://www.linkedin.com/in/luan-kobs/',
            'show_in_hero' => true,
            'show_in_contact' => true,
            'sort_order' => 2,
        ]);

        SocialLink::query()->create([
            'label' => '[Outro link]',
            'url' => 'https://example.com',
            'show_in_hero' => false,
            'show_in_contact' => true,
            'sort_order' => 3,
        ]);

        Experience::query()->create([
            'role' => '[Cargo]',
            'company' => '[Empresa]',
            'start_year' => 2023,
            'end_year' => null,
            'impact' => '[Uma linha sobre o impacto: o que você construiu, melhorou ou liderou.]',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Experience::query()->create([
            'role' => '[Cargo]',
            'company' => '[Empresa]',
            'start_year' => 2021,
            'end_year' => 2023,
            'impact' => '[Uma linha sobre o impacto: o que você construiu, melhorou ou liderou.]',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        Experience::query()->create([
            'role' => '[Cargo]',
            'company' => '[Empresa]',
            'start_year' => 2019,
            'end_year' => 2021,
            'impact' => '[Uma linha sobre o impacto: o que você construiu, melhorou ou liderou.]',
            'sort_order' => 3,
            'is_published' => true,
        ]);

        Project::query()->create([
            'name' => '[Nome do projeto]',
            'slug' => 'projeto-01',
            'year' => 2025,
            'description' => '[O problema que ele resolve e o que você construiu, em duas frases. Se tiver um resultado concreto, cite aqui.]',
            'tags' => ['[React]', '[Node.js]', '[PostgreSQL]'],
            'live_url' => 'https://example.com/projeto-01',
            'repo_url' => 'https://github.com/luankobs/projeto-01',
            'image_path' => null,
            'image_alt' => null,
            'image_width' => null,
            'image_height' => null,
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Project::query()->create([
            'name' => '[Nome do projeto]',
            'slug' => 'projeto-02',
            'year' => 2024,
            'description' => '[Contexto: para quem foi feito, qual era a restrição e qual decisão técnica você tomou para resolver.]',
            'tags' => ['[Next.js]', '[TypeScript]'],
            'live_url' => 'https://example.com/projeto-02',
            'repo_url' => 'https://github.com/luankobs/projeto-02',
            'image_path' => null,
            'image_alt' => null,
            'image_width' => null,
            'image_height' => null,
            'sort_order' => 2,
            'is_published' => true,
        ]);

        Project::query()->create([
            'name' => '[Nome do projeto]',
            'slug' => 'projeto-03',
            'year' => 2023,
            'description' => '[Um projeto pessoal ou open source que mostre algo que você gosta de fazer. Uma frase sobre o porquê.]',
            'tags' => ['[Go]', '[CLI]'],
            'live_url' => null,
            'repo_url' => 'https://github.com/luankobs/projeto-03',
            'image_path' => null,
            'image_alt' => null,
            'image_width' => null,
            'image_height' => null,
            'sort_order' => 3,
            'is_published' => true,
        ]);
    }
}
