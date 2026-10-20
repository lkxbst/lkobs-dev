import { describe, expect, it } from 'vitest';
import fixtureData from '../data/portfolio.fixture.json';
import { PortfolioPayloadSchema } from './schema';

describe('PortfolioPayloadSchema', () => {
  it('validates the exported fixture payload without errors', () => {
    const parsed = PortfolioPayloadSchema.parse(fixtureData);
    expect(parsed.profile.handle).toBe('luan.kobs');
    expect(parsed.projects).toHaveLength(3);
  });

  it('rejects invalid payload', () => {
    expect(() =>
      PortfolioPayloadSchema.parse({
        ...fixtureData,
        profile: { ...fixtureData.profile, name: '' },
      }),
    ).toThrow();
  });
});
