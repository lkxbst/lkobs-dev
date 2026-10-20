import process from 'node:process';
import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';
import tailwindcss from '@tailwindcss/vite';

const siteUrl = process.env.PUBLIC_SITE_URL || 'https://luankobs.dev';

export default defineConfig({
  site: siteUrl,
  output: 'static',
  integrations: [sitemap()],
  image: {
    remotePatterns: [
      { protocol: 'http', hostname: 'localhost' },
      { protocol: 'http', hostname: '127.0.0.1' },
      { protocol: 'https', hostname: '**.luankobs.dev' },
      { protocol: 'https', hostname: 'luankobs.dev' },
    ],
  },
  vite: {
    plugins: [tailwindcss()],
  },
});
