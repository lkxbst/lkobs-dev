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
            'about_primary' => 'Sou desenvolvedor há [X] anos e trabalho no meio do caminho entre produto e engenharia: entender o problema do negócio, propor a solução mais eficiente que resolva e cuidar de cada detalhe na entrega.',
            'about_secondary' => 'Desenvolvo sistemas sob medida, plataformas SaaS, automações inteligentes e integrações com IA para empresas que precisam ganhar escala, velocidade e eficiência operacional.',
            'tools' => ['TypeScript', 'React', 'Node.js', 'PostgreSQL', 'Docker'],
            'email' => '[seu@email.com]',
            'resume_path' => null,
            'translations' => [
                'en' => [
                    'city' => '[your city]',
                    'headline' => 'Software developer based in [your city]. I build end-to-end web products, from database to interface, with clean code and well-explained decisions.',
                    'headlineHighlight' => 'clean code and well-explained decisions.',
                    'availabilityLabel' => 'Available for new projects',
                    'aboutPrimary' => 'I have been a developer for [X] years, working at the intersection of product and engineering: understanding the business problem, proposing the leanest solution that works, and caring for every delivery detail.',
                    'aboutSecondary' => 'I build custom software, SaaS platforms, intelligent automations, and AI integrations for companies looking to gain scale, speed, and operational efficiency.',
                ],
                'es' => [
                    'city' => '[tu ciudad]',
                    'headline' => 'Desarrollador de software en [tu ciudad]. Construyo productos web de extremo a extremo, desde la base de datos hasta la interfaz, con código simple y decisiones claras.',
                    'headlineHighlight' => 'código simple y decisiones claras.',
                    'availabilityLabel' => 'Disponible para nuevos proyectos',
                    'aboutPrimary' => 'Soy desarrollador desde hace [X] años y trabajo entre producto e ingeniería: entender el problema del negocio, proponer la solución más eficiente y cuidar cada detalle en la entrega.',
                    'aboutSecondary' => 'Desarrollo sistemas a medida, plataformas SaaS, automatizaciones inteligentes e integraciones con IA para empresas que necesitan ganar escala, velocidad y eficiencia operativa.',
                ],
            ],
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
            'label' => 'WhatsApp',
            'url' => 'https://wa.me/5500000000000?text=Ol%C3%A1%20Luan!%20Vi%20seu%20portf%C3%B3lio%20e%20gostaria%20de%20conversar%20sobre%20um%20projeto.',
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
            'translations' => [
                'en' => [
                    'role' => '[Role]',
                    'company' => '[Company]',
                    'impact' => '[One line about the impact: what you built, improved, or led.]',
                ],
                'es' => [
                    'role' => '[Cargo]',
                    'company' => '[Empresa]',
                    'impact' => '[Una línea sobre el impacto: lo que construiste, mejoraste o lideraste.]',
                ],
            ],
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Experience::query()->create([
            'role' => '[Cargo]',
            'company' => '[Empresa]',
            'start_year' => 2021,
            'end_year' => 2023,
            'impact' => '[Uma linha sobre o impacto: o que você construiu, melhorou ou liderou.]',
            'translations' => [
                'en' => [
                    'role' => '[Role]',
                    'company' => '[Company]',
                    'impact' => '[One line about the impact: what you built, improved, or led.]',
                ],
                'es' => [
                    'role' => '[Cargo]',
                    'company' => '[Empresa]',
                    'impact' => '[Una línea sobre el impacto: lo que construiste, mejoraste o lideraste.]',
                ],
            ],
            'sort_order' => 2,
            'is_published' => true,
        ]);

        Experience::query()->create([
            'role' => '[Cargo]',
            'company' => '[Empresa]',
            'start_year' => 2019,
            'end_year' => 2021,
            'impact' => '[Uma linha sobre o impacto: o que você construiu, melhorou ou liderou.]',
            'translations' => [
                'en' => [
                    'role' => '[Role]',
                    'company' => '[Company]',
                    'impact' => '[One line about the impact: what you built, improved, or led.]',
                ],
                'es' => [
                    'role' => '[Cargo]',
                    'company' => '[Empresa]',
                    'impact' => '[Una línea sobre el impacto: lo que construiste, mejoraste o lideraste.]',
                ],
            ],
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
            'translations' => [
                'en' => [
                    'name' => '[Project name]',
                    'description' => '[The problem it solves and what you built, in two sentences. Mention concrete results if available.]',
                ],
                'es' => [
                    'name' => '[Nombre del proyecto]',
                    'description' => '[El problema que resuelve y lo que construiste, en dos frases. Si tienes un resultado concreto, menciónalo aquí.]',
                ],
            ],
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
            'translations' => [
                'en' => [
                    'name' => '[Project name]',
                    'description' => '[Context: who it was built for, what the constraint was, and the technical decision you made to solve it.]',
                ],
                'es' => [
                    'name' => '[Nombre del proyecto]',
                    'description' => '[Contexto: para quién fue hecho, cuál era la restricción y qué decisión técnica tomaste para resolverlo.]',
                ],
            ],
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
            'translations' => [
                'en' => [
                    'name' => '[Project name]',
                    'description' => '[A personal or open-source project showcasing something you enjoy building. One sentence on why.]',
                ],
                'es' => [
                    'name' => '[Nombre del proyecto]',
                    'description' => '[Un proyecto personal u open source que muestre algo que te gusta construir. Una frase sobre el porqué.]',
                ],
            ],
            'sort_order' => 3,
            'is_published' => true,
        ]);
    }
}
