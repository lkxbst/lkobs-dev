import { describe, expect, it } from 'vitest';
import { buildPayloadFromContent } from '../data/content';
import { getUiStrings, isFilledText, localizePortfolio } from './i18n';
import { PortfolioPayloadSchema } from './schema';

describe('i18n localization and placeholder filtering', () => {
  it('returns localized UI strings for pt, en, and es', () => {
    expect(getUiStrings('pt').contact.whatsappButton).toBe('Chamar no WhatsApp');
    expect(getUiStrings('en').contact.whatsappButton).toBe('Chat on WhatsApp');
    expect(getUiStrings('es').contact.whatsappButton).toBe('Hablar por WhatsApp');
  });

  it('treats empty strings and bracketed placeholders as unfilled', () => {
    expect(isFilledText('')).toBe(false);
    expect(isFilledText('   ')).toBe(false);
    expect(isFilledText('[Cargo]')).toBe(false);
    expect(isFilledText('[seu@email.com]')).toBe(false);
    expect(isFilledText('Backend Developer')).toBe(true);
  });

  it('localizes portfolio payload for en and es and filters out any empty items', () => {
    const payload = PortfolioPayloadSchema.parse(buildPayloadFromContent());

    const enPayload = localizePortfolio(payload, 'en');
    expect(enPayload.profile.availabilityLabel).toBe('Available for new projects');
    expect(enPayload.experiences).toHaveLength(0);
    expect(enPayload.projects[0]?.name).toBe('lkobs.dev — Portfolio & Headless CMS');

    const esPayload = localizePortfolio(payload, 'es');
    expect(esPayload.profile.availabilityLabel).toBe('Disponible para nuevos proyectos');
    expect(esPayload.experiences).toHaveLength(0);
    expect(esPayload.projects[0]?.name).toBe('lkobs.dev — Portafolio & Headless CMS');
  });
});
