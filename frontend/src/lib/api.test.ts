import { afterEach, describe, expect, it, vi } from 'vitest';
import fixtureData from '../data/portfolio.fixture.json';
import { getPortfolioData } from './api';

describe('getPortfolioData', () => {
  afterEach(() => {
    vi.restoreAllMocks();
    vi.unstubAllEnvs();
  });

  it('returns validated fixture data when USE_FIXTURE=true', async () => {
    vi.stubEnv('USE_FIXTURE', 'true');
    const data = await getPortfolioData();
    expect(data.profile.handle).toBe('luan.kobs');
  });

  it('fetches from API_URL when USE_FIXTURE=false and validates with Zod', async () => {
    vi.stubEnv('USE_FIXTURE', 'false');
    vi.stubEnv('API_URL', 'http://localhost:8000');

    const fetchSpy = vi.spyOn(globalThis, 'fetch').mockResolvedValue(
      new Response(JSON.stringify(fixtureData), {
        status: 200,
        headers: { 'Content-Type': 'application/json' },
      }),
    );

    const data = await getPortfolioData();
    expect(fetchSpy).toHaveBeenCalledWith('http://localhost:8000/api/v1/portfolio', {
      headers: { Accept: 'application/json' },
    });
    expect(data.profile.name).toBe('Luan Kobs');
  });

  it('throws an error when API returns non-200 status (failing the build)', async () => {
    vi.stubEnv('USE_FIXTURE', 'false');
    vi.stubEnv('API_URL', 'http://localhost:8000');

    vi.spyOn(globalThis, 'fetch').mockResolvedValue(
      new Response('Internal Server Error', { status: 500 }),
    );

    await expect(getPortfolioData()).rejects.toThrow(/Failed to fetch portfolio payload.*HTTP 500/);
  });

  it('throws a Zod validation error when API returns invalid payload (failing the build)', async () => {
    vi.stubEnv('USE_FIXTURE', 'false');
    vi.stubEnv('API_URL', 'http://localhost:8000');

    vi.spyOn(globalThis, 'fetch').mockResolvedValue(
      new Response(JSON.stringify({ invalid: true }), {
        status: 200,
        headers: { 'Content-Type': 'application/json' },
      }),
    );

    await expect(getPortfolioData()).rejects.toThrow();
  });
});
