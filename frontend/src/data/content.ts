import type { Locale } from '../lib/i18n';
import type { PortfolioPayload } from '../lib/schema';

export interface LocalizedExperienceInput {
  role: string;
  company: string;
  startYear: number;
  endYear: number | null;
  impact: string;
}

export interface LocalizedProjectInput {
  name: string;
  slug: string;
  year: number;
  description: string;
  tags: string[];
  liveUrl: string | null;
  repoUrl: string | null;
  image: {
    url: string;
    alt: string;
    width: number;
    height: number;
  } | null;
}

export interface LocalizedPortfolioContent {
  city: string;
  availabilityLabel: string;
  headline: string;
  headlineHighlight: string;
  about: {
    primary: string;
    secondary: string;
  };
  experiences: LocalizedExperienceInput[];
  projects: LocalizedProjectInput[];
}

export interface PortfolioContentSource {
  name: string;
  handle: string;
  email: string;
  resumeUrl: string | null;
  isAvailable: boolean;
  tools: string[];
  socialLinks: {
    label: string;
    url: string;
    showInHero: boolean;
    showInContact: boolean;
  }[];
  locales: Record<Locale, LocalizedPortfolioContent>;
}

/**
 * Arquivo único de dados do portfólio (PT / EN / ES).
 * Campos deixados vazios ("", null ou []) não são renderizados na interface.
 */
export const portfolioContent: PortfolioContentSource = {
  name: 'Luan Kobs',
  handle: 'luan.kobs',
  email: '',
  resumeUrl: null,
  isAvailable: true,
  tools: ['PHP', 'Laravel', 'TypeScript', 'React', 'Node.js', 'PostgreSQL', 'Docker'],
  socialLinks: [
    {
      label: 'GitHub',
      url: 'https://github.com/lkxbst',
      showInHero: true,
      showInContact: true,
    },
    {
      label: 'LinkedIn',
      url: 'https://www.linkedin.com/in/luan-kobs/',
      showInHero: true,
      showInContact: true,
    },
    {
      label: 'WhatsApp',
      url: 'https://wa.me/5500000000000?text=Ol%C3%A1%20Luan!%20Vi%20seu%20portf%C3%B3lio%20e%20gostaria%20de%20conversar%20sobre%20um%20projeto.',
      showInHero: false,
      showInContact: true,
    },
  ],
  locales: {
    pt: {
      city: '',
      availabilityLabel: 'Disponível para novos projetos',
      headline:
        'Desenvolvedor de software. Construo produtos web de ponta a ponta, do banco de dados à interface, com código simples e decisões bem explicadas.',
      headlineHighlight: 'código simples e decisões bem explicadas.',
      about: {
        primary:
          'Trabalho no meio do caminho entre produto e engenharia: entender o problema do negócio, propor a solução mais eficiente que resolva e cuidar de cada detalhe na entrega.',
        secondary:
          'Desenvolvo sistemas sob medida, plataformas SaaS, automações inteligentes e integrações com IA para empresas que precisam ganhar escala, velocidade e eficiência operacional.',
      },
      experiences: [],
      projects: [
        {
          name: 'lkobs.dev — Portfólio & Headless CMS',
          slug: 'lkobs-dev',
          year: 2026,
          description:
            'Plataforma de portfólio multilíngue (PT/EN/ES) com painel administrativo em Laravel 12 + Filament 4 e frontend estático em Astro 5 com nota máxima no Lighthouse.',
          tags: ['Laravel 12', 'Filament 4', 'Astro 5', 'TypeScript', 'Tailwind CSS'],
          liveUrl: 'https://lkobs-dev.pages.dev',
          repoUrl: 'https://github.com/lkxbst/lkobs-dev',
          image: null,
        },
      ],
    },
    en: {
      city: '',
      availabilityLabel: 'Available for new projects',
      headline:
        'Software developer. I build end-to-end web products, from database to interface, with clean code and well-explained decisions.',
      headlineHighlight: 'clean code and well-explained decisions.',
      about: {
        primary:
          'I work at the intersection of product and engineering: understanding the business problem, proposing the leanest solution that works, and caring for every delivery detail.',
        secondary:
          'I build custom software, SaaS platforms, intelligent automations, and AI integrations for companies looking to gain scale, speed, and operational efficiency.',
      },
      experiences: [],
      projects: [
        {
          name: 'lkobs.dev — Portfolio & Headless CMS',
          slug: 'lkobs-dev',
          year: 2026,
          description:
            'Multilingual portfolio platform (PT/EN/ES) powered by a Laravel 12 + Filament 4 admin panel and an Astro 5 static frontend achieving 100/100 Lighthouse scores.',
          tags: ['Laravel 12', 'Filament 4', 'Astro 5', 'TypeScript', 'Tailwind CSS'],
          liveUrl: 'https://lkobs-dev.pages.dev',
          repoUrl: 'https://github.com/lkxbst/lkobs-dev',
          image: null,
        },
      ],
    },
    es: {
      city: '',
      availabilityLabel: 'Disponible para nuevos proyectos',
      headline:
        'Desarrollador de software. Construyo productos web de extremo a extremo, desde la base de datos hasta la interfaz, con código simple y decisiones claras.',
      headlineHighlight: 'código simple y decisiones claras.',
      about: {
        primary:
          'Trabajo entre producto e ingeniería: entender el problema del negocio, proponer la solución más eficiente y cuidar cada detalle en la entrega.',
        secondary:
          'Desarrollo sistemas a medida, plataformas SaaS, automatizaciones inteligentes e integraciones con IA para empresas que necesitan ganar escala, velocidad y eficiencia operativa.',
      },
      experiences: [],
      projects: [
        {
          name: 'lkobs.dev — Portafolio & Headless CMS',
          slug: 'lkobs-dev',
          year: 2026,
          description:
            'Plataforma de portafolio multilingüe (PT/EN/ES) con panel administrativo en Laravel 12 + Filament 4 y frontend estático en Astro 5 con puntuación 100/100 en Lighthouse.',
          tags: ['Laravel 12', 'Filament 4', 'Astro 5', 'TypeScript', 'Tailwind CSS'],
          liveUrl: 'https://lkobs-dev.pages.dev',
          repoUrl: 'https://github.com/lkxbst/lkobs-dev',
          image: null,
        },
      ],
    },
  },
};

export function buildPayloadFromContent(
  source: PortfolioContentSource = portfolioContent,
): PortfolioPayload {
  const pt = source.locales.pt;
  const en = source.locales.en;
  const es = source.locales.es;

  return {
    profile: {
      name: source.name,
      handle: source.handle,
      city: pt.city,
      headline: pt.headline,
      headlineHighlight: pt.headlineHighlight,
      isAvailable: source.isAvailable,
      availabilityLabel: pt.availabilityLabel,
      about: {
        primary: pt.about.primary,
        secondary: pt.about.secondary,
      },
      tools: source.tools,
      email: source.email,
      resumeUrl: source.resumeUrl,
      translations: {
        en: {
          city: en.city,
          headline: en.headline,
          headlineHighlight: en.headlineHighlight,
          availabilityLabel: en.availabilityLabel,
          aboutPrimary: en.about.primary,
          aboutSecondary: en.about.secondary,
        },
        es: {
          city: es.city,
          headline: es.headline,
          headlineHighlight: es.headlineHighlight,
          availabilityLabel: es.availabilityLabel,
          aboutPrimary: es.about.primary,
          aboutSecondary: es.about.secondary,
        },
      },
    },
    socialLinks: source.socialLinks,
    experiences: pt.experiences.map((exp, idx) => ({
      ...exp,
      translations: {
        en: en.experiences[idx]
          ? {
              role: en.experiences[idx].role,
              company: en.experiences[idx].company,
              impact: en.experiences[idx].impact,
            }
          : {},
        es: es.experiences[idx]
          ? {
              role: es.experiences[idx].role,
              company: es.experiences[idx].company,
              impact: es.experiences[idx].impact,
            }
          : {},
      },
    })),
    projects: pt.projects.map((proj, idx) => ({
      number: String(idx + 1).padStart(2, '0'),
      ...proj,
      translations: {
        en: en.projects[idx]
          ? {
              name: en.projects[idx].name,
              description: en.projects[idx].description,
              imageAlt: en.projects[idx].image?.alt ?? null,
            }
          : {},
        es: es.projects[idx]
          ? {
              name: es.projects[idx].name,
              description: es.projects[idx].description,
              imageAlt: es.projects[idx].image?.alt ?? null,
            }
          : {},
      },
    })),
    updatedAt: '2026-10-19T00:00:00+00:00',
  };
}
