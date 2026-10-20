import { describe, expect, it } from 'vitest';
import fixtureData from '../data/portfolio.fixture.json';
import { getUiStrings, localizePortfolio } from './i18n';
import { PortfolioPayloadSchema } from './schema';

describe('i18n localization', () => {
  it('returns localized UI strings for pt, en, and es', () => {
    expect(getUiStrings('pt').contact.whatsappButton).toBe('Chamar no WhatsApp');
    expect(getUiStrings('en').contact.whatsappButton).toBe('Chat on WhatsApp');
    expect(getUiStrings('es').contact.whatsappButton).toBe('Hablar por WhatsApp');
  });

  it('localizes portfolio payload for en and es with fallback to pt', () => {
    const payload = PortfolioPayloadSchema.parse(fixtureData);

    const enPayload = localizePortfolio(payload, 'en');
    expect(enPayload.profile.availabilityLabel).toBe('Available for new projects');
    expect(enPayload.experiences[0]?.role).toBe('[Role]');
    expect(enPayload.projects[0]?.name).toBe('[Project name]');

    const esPayload = localizePortfolio(payload, 'es');
    expect(esPayload.profile.availabilityLabel).toBe('Disponible para nuevos proyectos');
    expect(esPayload.experiences[0]?.role).toBe('[Cargo]');
    expect(esPayload.projects[0]?.name).toBe('[Nombre del proyecto]');
  });
});
