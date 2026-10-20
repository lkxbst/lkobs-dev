import { defineConfig } from '@playwright/test';

export default defineConfig({
  testDir: './tests/e2e',
  fullyParallel: true,
  retries: 0,
  use: {
    baseURL: 'http://localhost:4322',
    colorScheme: 'dark',
    trace: 'on-first-retry',
  },
  webServer: {
    command: 'npm run preview -- --port 4322 --host 127.0.0.1',
    url: 'http://localhost:4322',
    reuseExistingServer: !process.env.CI,
    timeout: 60000,
  },
});
