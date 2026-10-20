export function formatProjectNumber(position: number): string {
  return String(position).padStart(2, '0');
}

export function formatExperiencePeriod(
  startYear: number,
  endYear: number | null,
  presentLabel = 'hoje',
): string {
  const end = endYear !== null ? String(endYear) : presentLabel;
  return `${startYear} — ${end}`;
}

export function splitHeadline(
  headline: string,
  highlight: string,
): { before: string; highlight: string; after: string } {
  const index = headline.indexOf(highlight);
  if (index === -1) {
    return { before: headline, highlight: '', after: '' };
  }

  return {
    before: headline.slice(0, index),
    highlight,
    after: headline.slice(index + highlight.length),
  };
}
