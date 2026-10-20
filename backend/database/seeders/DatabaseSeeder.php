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
            'city' => '',
            'headline' => 'Desenvolvedor de software. Construo produtos web de ponta a ponta, do banco de dados à interface, com código simples e decisões bem explicadas.',
            'headline_highlight' => 'código simples e decisões bem explicadas.',
            'is_available' => true,
            'availability_label' => 'Disponível para novos projetos',
            'about_primary' => 'Trabalho no meio do caminho entre produto e engenharia: entender o problema do negócio, propor a solução mais eficiente que resolva e cuidar de cada detalhe na entrega.',
            'about_secondary' => 'Desenvolvo sistemas sob medida, plataformas SaaS, automações inteligentes e integrações com IA para empresas que precisam ganhar escala, velocidade e eficiência operacional.',
            'tools' => ['PHP', 'Laravel', 'TypeScript', 'React', 'Node.js', 'PostgreSQL', 'Docker'],
            'email' => '',
            'resume_path' => null,
            'translations' => [
                'en' => [
                    'city' => '',
                    'headline' => 'Software developer. I build end-to-end web products, from database to interface, with clean code and well-explained decisions.',
                    'headlineHighlight' => 'clean code and well-explained decisions.',
                    'availabilityLabel' => 'Available for new projects',
                    'aboutPrimary' => 'I work at the intersection of product and engineering: understanding the business problem, proposing the leanest solution that works, and caring for every delivery detail.',
                    'aboutSecondary' => 'I build custom software, SaaS platforms, intelligent automations, and AI integrations for companies looking to gain scale, speed, and operational efficiency.',
                ],
                'es' => [
                    'city' => '',
                    'headline' => 'Desarrollador de software. Construyo productos web de extremo a extremo, desde la base de datos hasta la interfaz, con código simple y decisiones claras.',
                    'headlineHighlight' => 'código simple y decisiones claras.',
                    'availabilityLabel' => 'Disponible para nuevos proyectos',
                    'aboutPrimary' => 'Trabajo entre producto e ingeniería: entender el problema del negocio, proponer la solución más eficiente y cuidar cada detalle en la entrega.',
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

        Project::query()->create([
            'name' => 'lkobs.dev — Portfólio & Headless CMS',
            'slug' => 'lkobs-dev',
            'year' => 2026,
            'description' => 'Plataforma de portfólio multilíngue (PT/EN/ES) com painel administrativo em Laravel 12 + Filament 4 e frontend estático em Astro 5 com nota máxima no Lighthouse.',
            'tags' => ['Laravel 12', 'Filament 4', 'Astro 5', 'TypeScript', 'Tailwind CSS'],
            'live_url' => 'https://lkobs-dev.pages.dev',
            'repo_url' => 'https://github.com/lkxbst/lkobs-dev',
            'image_path' => null,
            'image_alt' => null,
            'image_width' => null,
            'image_height' => null,
            'translations' => [
                'en' => [
                    'name' => 'lkobs.dev — Portfolio & Headless CMS',
                    'description' => 'Multilingual portfolio platform (PT/EN/ES) powered by a Laravel 12 + Filament 4 admin panel and an Astro 5 static frontend achieving 100/100 Lighthouse scores.',
                ],
                'es' => [
                    'name' => 'lkobs.dev — Portafolio & Headless CMS',
                    'description' => 'Plataforma de portafolio multilingüe (PT/EN/ES) con panel administrativo en Laravel 12 + Filament 4 y frontend estático en Astro 5 con puntuación 100/100 en Lighthouse.',
                ],
            ],
            'sort_order' => 1,
            'is_published' => true,
        ]);
    }
}
