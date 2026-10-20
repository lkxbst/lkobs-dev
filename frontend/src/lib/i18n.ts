import type { PortfolioPayload } from './schema';

export type Locale = 'pt' | 'en' | 'es';

export const LOCALES: readonly { code: Locale; label: string; href: string; hreflang: string }[] = [
  { code: 'pt', label: 'PT', href: '/', hreflang: 'pt-BR' },
  { code: 'en', label: 'EN', href: '/en/', hreflang: 'en' },
  { code: 'es', label: 'ES', href: '/es/', hreflang: 'es' },
];

export interface UiStrings {
  htmlLang: string;
  ogLocale: string;
  jobTitle: string;
  skipToContent: string;
  navAriaLabel: string;
  langSwitcherAriaLabel: string;
  menuLabel: string;
  nav: {
    about: string;
    experience: string;
    projects: string;
    contact: string;
  };
  hero: {
    ariaLabel: string;
    resumePdf: string;
  };
  about: {
    label: string;
    toolsLabel: string;
  };
  experience: {
    label: string;
    presentLabel: string;
    fullResumePdf: string;
  };
  projects: {
    label: string;
    liveProject: string;
    sourceCode: string;
    techUsedAria: string;
    screenshotPlaceholder: string;
    moreOnGithub: string;
  };
  contact: {
    label: string;
    heading: string;
    whatsappButton: string;
    whatsappMessage: string;
  };
  footer: {
    backToTop: string;
  };
}

const UI_DICTIONARY: Record<Locale, UiStrings> = {
  pt: {
    htmlLang: 'pt-BR',
    ogLocale: 'pt_BR',
    jobTitle: 'Desenvolvedor de Software',
    skipToContent: 'Pular para o conteúdo',
    navAriaLabel: 'Navegação principal',
    langSwitcherAriaLabel: 'Selecionar idioma',
    menuLabel: 'Menu',
    nav: {
      about: 'Sobre',
      experience: 'Experiência',
      projects: 'Projetos',
      contact: 'Contato',
    },
    hero: {
      ariaLabel: 'Apresentação',
      resumePdf: 'Currículo (PDF)',
    },
    about: {
      label: 'Sobre',
      toolsLabel: 'Ferramentas',
    },
    experience: {
      label: 'Experiência',
      presentLabel: 'hoje',
      fullResumePdf: 'Currículo completo (PDF)',
    },
    projects: {
      label: 'Projetos',
      liveProject: 'Ver projeto',
      sourceCode: 'Código',
      techUsedAria: 'Tecnologias utilizadas',
      screenshotPlaceholder: 'captura de tela do projeto',
      moreOnGithub: 'Mais no GitHub',
    },
    contact: {
      label: 'Contato',
      heading: 'Quer tirar uma ideia do papel ou escalar seu produto digital? Vamos conversar.',
      whatsappButton: 'Chamar no WhatsApp',
      whatsappMessage: 'Olá Luan! Vi seu portfólio e gostaria de conversar sobre um projeto.',
    },
    footer: {
      backToTop: 'Voltar ao topo',
    },
  },
  en: {
    htmlLang: 'en',
    ogLocale: 'en_US',
    jobTitle: 'Software Developer',
    skipToContent: 'Skip to content',
    navAriaLabel: 'Main navigation',
    langSwitcherAriaLabel: 'Select language',
    menuLabel: 'Menu',
    nav: {
      about: 'About',
      experience: 'Experience',
      projects: 'Projects',
      contact: 'Contact',
    },
    hero: {
      ariaLabel: 'Introduction',
      resumePdf: 'Resume (PDF)',
    },
    about: {
      label: 'About',
      toolsLabel: 'Tools & Stack',
    },
    experience: {
      label: 'Experience',
      presentLabel: 'present',
      fullResumePdf: 'Full resume (PDF)',
    },
    projects: {
      label: 'Projects',
      liveProject: 'Live project',
      sourceCode: 'Source',
      techUsedAria: 'Technologies used',
      screenshotPlaceholder: 'project screenshot',
      moreOnGithub: 'More on GitHub',
    },
    contact: {
      label: 'Contact',
      heading: 'Looking to bring an idea to life or scale your digital product? Let’s talk.',
      whatsappButton: 'Chat on WhatsApp',
      whatsappMessage: 'Hi Luan! I saw your portfolio and would like to talk about a project.',
    },
    footer: {
      backToTop: 'Back to top',
    },
  },
  es: {
    htmlLang: 'es',
    ogLocale: 'es_ES',
    jobTitle: 'Desarrollador de Software',
    skipToContent: 'Saltar al contenido',
    navAriaLabel: 'Navegación principal',
    langSwitcherAriaLabel: 'Seleccionar idioma',
    menuLabel: 'Menú',
    nav: {
      about: 'Sobre mí',
      experience: 'Experiencia',
      projects: 'Proyectos',
      contact: 'Contacto',
    },
    hero: {
      ariaLabel: 'Presentación',
      resumePdf: 'Currículum (PDF)',
    },
    about: {
      label: 'Sobre mí',
      toolsLabel: 'Herramientas',
    },
    experience: {
      label: 'Experiencia',
      presentLabel: 'actualidad',
      fullResumePdf: 'Currículum completo (PDF)',
    },
    projects: {
      label: 'Proyectos',
      liveProject: 'Ver proyecto',
      sourceCode: 'Código',
      techUsedAria: 'Tecnologías utilizadas',
      screenshotPlaceholder: 'captura de pantalla del proyecto',
      moreOnGithub: 'Más en GitHub',
    },
    contact: {
      label: 'Contacto',
      heading: '¿Quieres hacer realidad una idea o escalar tu producto digital? Hablemos.',
      whatsappButton: 'Hablar por WhatsApp',
      whatsappMessage: '¡Hola Luan! Vi tu portafolio y me gustaría hablar sobre un proyecto.',
    },
    footer: {
      backToTop: 'Volver arriba',
    },
  },
};

export function getUiStrings(locale: Locale = 'pt'): UiStrings {
  return UI_DICTIONARY[locale];
}

function nonEmpty(value: string | null | undefined, fallback: string): string {
  return value && value.trim().length > 0 ? value : fallback;
}

export function localizePortfolio(
  payload: PortfolioPayload,
  locale: Locale = 'pt',
): PortfolioPayload {
  if (locale === 'pt') {
    return payload;
  }

  const profileTrans = payload.profile.translations?.[locale];
  const localizedProfile = {
    ...payload.profile,
    city: nonEmpty(profileTrans?.city, payload.profile.city),
    headline: nonEmpty(profileTrans?.headline, payload.profile.headline),
    headlineHighlight: nonEmpty(profileTrans?.headlineHighlight, payload.profile.headlineHighlight),
    availabilityLabel: nonEmpty(profileTrans?.availabilityLabel, payload.profile.availabilityLabel),
    about: {
      primary: nonEmpty(profileTrans?.aboutPrimary, payload.profile.about.primary),
      secondary: nonEmpty(profileTrans?.aboutSecondary, payload.profile.about.secondary),
    },
  };

  const localizedExperiences = payload.experiences.map((exp) => {
    const expTrans = exp.translations?.[locale];
    return {
      ...exp,
      role: nonEmpty(expTrans?.role, exp.role),
      company: nonEmpty(expTrans?.company, exp.company),
      impact: nonEmpty(expTrans?.impact, exp.impact),
    };
  });

  const localizedProjects = payload.projects.map((proj) => {
    const projTrans = proj.translations?.[locale];
    return {
      ...proj,
      name: nonEmpty(projTrans?.name, proj.name),
      description: nonEmpty(projTrans?.description, proj.description),
      image: proj.image
        ? {
            ...proj.image,
            alt: nonEmpty(projTrans?.imageAlt, proj.image.alt),
          }
        : null,
    };
  });

  return {
    ...payload,
    profile: localizedProfile,
    experiences: localizedExperiences,
    projects: localizedProjects,
  };
}
