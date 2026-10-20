import type { APIRoute } from 'astro';
import sharp from 'sharp';

export const GET: APIRoute = async () => {
  const svg = `
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64">
      <rect width="64" height="64" rx="12" fill="#1A1917" />
      <circle cx="32" cy="32" r="10" fill="#E8774A" />
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
