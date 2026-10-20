import AxeBuilder from '@axe-core/playwright';
import { expect, test } from '@playwright/test';

test.describe('Portfolio UI, Responsive, Keyboard & Accessibility Checks', () => {
  test('aligns section grids, omits experience/resume, applies Grafite quente palette, and has no horizontal overflow at 1440px, 1024px, and 375px in both themes', async ({
    page,
  }) => {
    for (const width of [1440, 1024, 375]) {
      const height = width === 375 ? 812 : 900;
      await page.setViewportSize({ width, height });
      await page.goto('/');

      await expect(page.locator('main h1')).toHaveText('Luan Kobs');
      await expect(page.locator('#sobre')).toBeVisible();
      await expect(page.locator('#experiencia')).toHaveCount(0);
      await expect(page.locator('a[href="/cv"]')).toHaveCount(0);
      await expect(page.locator('#projetos')).toBeVisible();
      await expect(page.locator('#contato')).toBeVisible();

      // Verify theme-color meta tags
      await expect(
        page.locator('meta[name="theme-color"][media="(prefers-color-scheme: dark)"]'),
      ).toHaveAttribute('content', '#1A1917');
      await expect(
        page.locator('meta[name="theme-color"][media="(prefers-color-scheme: light)"]'),
      ).toHaveAttribute('content', '#F2EFE8');

      // No bracketed placeholders should appear anywhere in main
      const mainText = await page.locator('main').innerText();
      expect(mainText).not.toMatch(
        /\[(sua cidade|X|Cargo|Empresa|Nome do projeto|seu@email\.com|React)\]/,
      );

      // Verify all visible sections' content columns start at the exact same x coordinate on desktop (>= 1024px)
      if (width >= 1024) {
        const sobreContentBox = await page
          .locator('#sobre .section-grid > div:nth-child(2)')
          .boundingBox();
        const projContentBox = await page
          .locator('#projetos .section-grid > div:nth-child(2)')
          .boundingBox();
        const contatoContentBox = await page
          .locator('#contato .section-grid > div:nth-child(2)')
          .boundingBox();

        expect(sobreContentBox).not.toBeNull();
        expect(projContentBox?.x).toBe(sobreContentBox?.x);
        expect(contatoContentBox?.x).toBe(sobreContentBox?.x);

        // Verify header divider (1px x 16px) and 32-40px spacing between nav and preferences
        const dividerBox = await page.locator('[data-header-divider]').boundingBox();
        const navBox = await page.locator('[data-header-nav]').boundingBox();
        const prefBox = await page.locator('[data-header-preferences]').boundingBox();
        expect(dividerBox?.width).toBe(1);
        expect(dividerBox?.height).toBe(16);
        if (navBox && prefBox) {
          const gapBetweenGroups = prefBox.x - (navBox.x + navBox.width);
          expect(gapBetweenGroups).toBeGreaterThanOrEqual(32);
          expect(gapBetweenGroups).toBeLessThanOrEqual(40);
        }

        // Verify desktop click target sizes: nav >= 32px, lang button >= 32px, theme toggle == 36px
        const navLinkBox = await page.locator('[data-nav-link]').first().boundingBox();
        const langBtnBox = await page.locator('[data-lang-dropdown-button]').boundingBox();
        const themeBtnBox = await page.locator('[data-theme-toggle]').boundingBox();
        expect(navLinkBox?.height).toBeGreaterThanOrEqual(32);
        expect(langBtnBox?.height).toBeGreaterThanOrEqual(32);
        expect(themeBtnBox?.height).toBe(36);
        expect(themeBtnBox?.width).toBe(36);
      } else {
        // Mobile (375px) click targets >= 44px
        const menuBtnBox = await page.locator('[data-mobile-menu-button]').boundingBox();
        const themeBtnBox = await page.locator('[data-theme-toggle]').boundingBox();
        expect(menuBtnBox?.height).toBeGreaterThanOrEqual(44);
        expect(themeBtnBox?.height).toBeGreaterThanOrEqual(44);
      }

      // Check dark and light themes at this viewport
      for (const theme of ['dark', 'light'] as const) {
        if (theme === 'light') {
          await page.locator('[data-theme-toggle]').click();
        }
        await expect(page.locator('html')).toHaveAttribute('data-theme', theme);

        // Verify CSS token values and body background color
        const tokens = await page.evaluate(() => {
          const s = getComputedStyle(document.documentElement);
          const bodyBg = getComputedStyle(document.body).backgroundColor;
          return {
            bg: s.getPropertyValue('--bg').trim().toLowerCase(),
            surface: s.getPropertyValue('--surface').trim().toLowerCase(),
            fg: s.getPropertyValue('--fg').trim().toLowerCase(),
            muted: s.getPropertyValue('--muted').trim().toLowerCase(),
            line: s.getPropertyValue('--line').trim().toLowerCase(),
            accent: s.getPropertyValue('--accent').trim().toLowerCase(),
            bodyBg,
          };
        });

        if (theme === 'dark') {
          expect(tokens.bg).toBe('#1a1917');
          expect(tokens.surface).toBe('#22211e');
          expect(tokens.fg).toBe('#e9e5dd');
          expect(tokens.muted).toBe('#a29d93');
          expect(tokens.line).toBe('#302e2a');
          expect(tokens.accent).toBe('#e8774a');
          expect(tokens.bodyBg).toBe('rgb(26, 25, 23)');
        } else {
          expect(tokens.bg).toBe('#f2efe8');
          expect(tokens.surface).toBe('#e8e4da');
          expect(tokens.fg).toBe('#1f1d1a');
          expect(tokens.muted).toBe('#6a655c');
          expect(tokens.line).toBe('#dad5ca');
          expect(tokens.accent).toBe('#ac451e');
          expect(tokens.bodyBg).toBe('rgb(242, 239, 232)');
        }

        // Verify keyboard focus outline visibility in both themes via Tab navigation
        await page.locator('a[href="#conteudo-principal"]').focus();
        await page.keyboard.press('Tab');
        const focusOutline = await page.evaluate(() => {
          const active = document.activeElement;
          if (!active) return { style: 'none', width: '0px', color: '' };
          const cs = getComputedStyle(active);
          return { style: cs.outlineStyle, width: cs.outlineWidth, color: cs.outlineColor };
        });
        expect(focusOutline.style).toBe('solid');
        expect(focusOutline.width).toBe('2px');
        expect(focusOutline.color).toBe(
          theme === 'dark' ? 'rgb(232, 119, 74)' : 'rgb(172, 69, 30)',
        );

        const overflow = await page.evaluate(
          () => document.documentElement.scrollWidth > document.documentElement.clientWidth,
        );
        expect(overflow).toBe(false);
      }

      // Reset back to dark for next viewport iteration
      await page.locator('[data-theme-toggle]').click();
    }
  });

  test('language dropdown works via keyboard (arrows, Enter, Escape), outside click, and shows visible focus', async ({
    page,
  }) => {
    await page.setViewportSize({ width: 1440, height: 900 });
    await page.goto('/');

    const langButton = page.locator('[data-lang-dropdown-button]');
    const langList = page.locator('[data-lang-dropdown-list]');

    await expect(langButton).toBeVisible();
    await expect(langButton).toHaveAttribute('aria-haspopup', 'listbox');
    await expect(langButton).toHaveAttribute('aria-expanded', 'false');
    await expect(langList).toBeHidden();

    // Focus button via keyboard and verify visible focus outline
    await langButton.focus();
    const outlineStyle = await langButton.evaluate((el) => getComputedStyle(el).outlineStyle);
    expect(outlineStyle).not.toBe('none');

    // Open with ArrowDown and navigate options
    await page.keyboard.press('ArrowDown');
    await expect(langButton).toHaveAttribute('aria-expanded', 'true');
    await expect(langList).toBeVisible();

    const ptOption = page.locator('[data-lang-option="pt"]');
    const enOption = page.locator('[data-lang-option="en"]');
    await expect(ptOption).toHaveAttribute('aria-selected', 'true');
    await expect(ptOption).toBeFocused();

    await page.keyboard.press('ArrowDown');
    await expect(enOption).toBeFocused();

    // Close with Escape and verify focus returns to button
    await page.keyboard.press('Escape');
    await expect(langButton).toHaveAttribute('aria-expanded', 'false');
    await expect(langList).toBeHidden();
    await expect(langButton).toBeFocused();

    // Open by click and close by outside click
    await langButton.click();
    await expect(langList).toBeVisible();
    await page.locator('main h1').click();
    await expect(langList).toBeHidden();

    // Open with keyboard, ArrowDown to EN, and press Enter to navigate
    await langButton.focus();
    await page.keyboard.press('ArrowDown');
    await page.keyboard.press('ArrowDown');
    await page.keyboard.press('Enter');
    await expect(page).toHaveURL(/\/en\/?$/);
    await expect(page.locator('html')).toHaveAttribute('lang', 'en');
  });

  test('mobile menu opens and closes via keyboard with >= 44px touch targets', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 812 });
    await page.goto('/');

    const menuButton = page.locator('[data-mobile-menu-button]');
    const menuPanel = page.locator('[data-mobile-menu-panel]');

    await expect(menuButton).toBeVisible();
    await expect(menuPanel).toBeHidden();

    await menuButton.focus();
    await page.keyboard.press('Enter');

    await expect(menuButton).toHaveAttribute('aria-expanded', 'true');
    await expect(menuPanel).toBeVisible();

    const firstMobileLinkBox = await page.locator('[data-mobile-menu-link]').first().boundingBox();
    expect(firstMobileLinkBox?.height).toBeGreaterThanOrEqual(44);

    await page.keyboard.press('Escape');
    await expect(menuButton).toHaveAttribute('aria-expanded', 'false');
    await expect(menuPanel).toBeHidden();
  });

  test('passes axe accessibility checks in dark theme, light theme, /en, /es, and 404 page', async ({
    page,
  }) => {
    await page.setViewportSize({ width: 1440, height: 900 });
    await page.goto('/');

    const darkResults = await new AxeBuilder({ page }).exclude('astro-dev-toolbar').analyze();
    expect(darkResults.violations).toEqual([]);

    await page.locator('[data-theme-toggle]').click();
    await expect(page.locator('html')).toHaveAttribute('data-theme', 'light');

    const lightResults = await new AxeBuilder({ page }).exclude('astro-dev-toolbar').analyze();
    expect(lightResults.violations).toEqual([]);

    await page.goto('/en/');
    await expect(page.locator('html')).toHaveAttribute('lang', 'en');
    await expect(page.locator('#contato')).toContainText('Chat on WhatsApp');
    const enResults = await new AxeBuilder({ page }).exclude('astro-dev-toolbar').analyze();
    expect(enResults.violations).toEqual([]);

    await page.goto('/es/');
    await expect(page.locator('html')).toHaveAttribute('lang', 'es');
    await expect(page.locator('#contato')).toContainText('Hablar por WhatsApp');
    const esResults = await new AxeBuilder({ page }).exclude('astro-dev-toolbar').analyze();
    expect(esResults.violations).toEqual([]);

    await page.goto('/404');
    await expect(page.locator('main h1')).toContainText('Página não encontrada');
    const notFoundResults = await new AxeBuilder({ page }).exclude('astro-dev-toolbar').analyze();
    expect(notFoundResults.violations).toEqual([]);
  });
});
