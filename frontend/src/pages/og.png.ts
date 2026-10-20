import type { APIRoute } from 'astro';
import sharp from 'sharp';
import { getPortfolioData } from '../lib/api';

function escapeXml(unsafe: string): string {
  return unsafe
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&apos;');
}

export const GET: APIRoute = async () => {
  const { profile } = await getPortfolioData();
  const handle = escapeXml(profile.handle);
  const name = escapeXml(profile.name);
  const availability = escapeXml(profile.availabilityLabel);

  const svg = `
    <svg width="1200" height="630" viewBox="0 0 1200 630" xmlns="http://www.w3.org/2000/svg">
      <rect width="1200" height="630" fill="#1A1917" />
      <line x1="0" y1="88" x2="1200" y2="88" stroke="#302E2A" stroke-width="2" />
      <text x="80" y="54" fill="#E9E5DD" font-family="monospace" font-size="22" font-weight="600">${handle}</text>
      <circle cx="88" cy="210" r="7" fill="#E8774A" />
      <text x="110" y="216" fill="#A29D93" font-family="monospace" font-size="20">${availability}</text>
      <text x="80" y="340" fill="#E9E5DD" font-family="sans-serif" font-size="96" font-weight="600" letter-spacing="-2">${name}</text>
      <text x="80" y="425" fill="#A29D93" font-family="sans-serif" font-size="32">Desenvolvedor de software · Backend &amp; Produtos Web</text>
      <text x="80" y="475" fill="#E9E5DD" font-family="sans-serif" font-size="32">Código simples e decisões bem explicadas.</text>
      <line x1="80" y1="530" x2="360" y2="530" stroke="#E8774A" stroke-width="4" />
    </svg>
  `;

  const pngBuffer = await sharp(Buffer.from(svg)).png().toBuffer();

  return new Response(new Uint8Array(pngBuffer), {
    headers: {
      'Content-Type': 'image/png',
      'Cache-Control': 'public, max-age=31536000, immutable',
    },
  });
};
