import type { APIRoute } from 'astro';

export const GET: APIRoute = ({ site }) => {
  const baseUrl = site ? site.toString().replace(/\/$/, '') : 'https://luankobs.dev';
  const body = `User-agent: *\nAllow: /\n\nSitemap: ${baseUrl}/sitemap-index.xml\n`;

  return new Response(body, {
    headers: {
      'Content-Type': 'text/plain; charset=utf-8',
    },
  });
};
