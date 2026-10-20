import { describe, expect, it } from 'vitest';
import { formatExperiencePeriod, formatProjectNumber, splitHeadline } from './format';

describe('format helpers', () => {
  it('pads project numbers with leading zero', () => {
    expect(formatProjectNumber(1)).toBe('01');
    expect(formatProjectNumber(9)).toBe('09');
    expect(formatProjectNumber(10)).toBe('10');
  });

  it('formats experience period with open or closed endYear', () => {
    expect(formatExperiencePeriod(2023, null)).toBe('2023 — hoje');
    expect(formatExperiencePeriod(2021, 2023)).toBe('2021 — 2023');
  });

  it('splits headline into before, highlight, and after segments', () => {
    const headline =
      'Desenvolvedor de software em [sua cidade]. Construo produtos web com código simples e decisões bem explicadas.';
    const highlight = 'código simples e decisões bem explicadas.';

    expect(splitHeadline(headline, highlight)).toEqual({
      before: 'Desenvolvedor de software em [sua cidade]. Construo produtos web com ',
      highlight: 'código simples e decisões bem explicadas.',
      after: '',
    });
  });
});
