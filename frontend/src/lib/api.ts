import { buildPayloadFromContent, portfolioContent } from '../data/content';
import { PortfolioPayloadSchema, type PortfolioPayload } from './schema';

export async function getPortfolioData(): Promise<PortfolioPayload> {
  const useFixtureEnv = process.env.USE_FIXTURE ?? import.meta.env?.USE_FIXTURE ?? 'true';
  const useFixture = useFixtureEnv === 'true' || useFixtureEnv === '1';

  if (useFixture) {
    return PortfolioPayloadSchema.parse(buildPayloadFromContent(portfolioContent));
  }

  const baseUrl = (
    process.env.API_URL ??
    import.meta.env?.API_URL ??
    'http://localhost:8000'
  ).replace(/\/$/, '');

  const endpoint = `${baseUrl}/api/v1/portfolio`;
  const response = await fetch(endpoint, {
    headers: { Accept: 'application/json' },
  });

  if (!response.ok) {
    throw new Error(`Failed to fetch portfolio payload from ${endpoint}: HTTP ${response.status}`);
  }

  const rawJson: unknown = await response.json();
  return PortfolioPayloadSchema.parse(rawJson);
}
