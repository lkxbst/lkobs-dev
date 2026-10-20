import AxeBuilder from '@axe-core/playwright';
import { expect, test } from '@playwright/test';

test.describe('Portfolio Smoke, Responsive & Accessibility Checks', () => {
  test('renders all sections from fixture and has no horizontal scroll at 1440px, 768px and 390px', async ({
    page,
  }) => {
    await page.setViewportSize({ width: 1440, height: 900 });
    await page.goto('/');

    await expect(page.locator('main h1')).toHaveText('Luan Kobs');
    await expect(page.locator('#sobre')).toBeVisible();
    await expect(page.locator('#experiencia')).toBeVisible();
    await expect(page.locator('#projetos')).toBeVisible();
    await expect(page.locator('#contato')).toBeVisible();

    const desktopOverflow = await page.evaluate(
      () => document.documentElement.scrollWidth > document.documentElement.clientWidth,
    );
    expect(desktopOverflow).toBe(false);

    await page.screenshot({
      path: 'test-results/desktop-1440-dark.png',
      fullPage: true,
    });

    await page.setViewportSize({ width: 768, height: 1024 });
    const tabletOverflow = await page.evaluate(
      () => document.documentElement.scrollWidth > document.documentElement.clientWidth,
    );
    expect(tabletOverflow).toBe(false);
    await page.screenshot({
      path: 'test-results/tablet-768-dark.png',
      fullPage: true,
    });

    await page.setViewportSize({ width: 390, height: 844 });
    const mobileOverflow = await page.evaluate(
      () => document.documentElement.scrollWidth > document.documentElement.clientWidth,
    );
    expect(mobileOverflow).toBe(false);
    await page.screenshot({
      path: 'test-results/mobile-390-dark.png',
      fullPage: true,
    });
  });

  test('toggles theme and persists in localStorage without flash', async ({ page }) => {
    await page.setViewportSize({ width: 1440, height: 900 });
    await page.goto('/');

    const html = page.locator('html');
    await expect(html).toHaveAttribute('data-theme', 'dark');

    const toggle = page.locator('[data-theme-toggle]');
    await toggle.click();

    await expect(html).toHaveAttribute('data-theme', 'light');
    await expect(toggle).toHaveAttribute('aria-pressed', 'true');

    await page.screenshot({
      path: 'test-results/desktop-1440-light.png',
      fullPage: true,
    });

    await page.reload();
    await expect(html).toHaveAttribute('data-theme', 'light');
  });

  test('mobile menu opens and closes via keyboard and anchor links work', async ({ page }) => {
    await page.setViewportSize({ width: 390, height: 844 });
    await page.goto('/');

    const menuButton = page.locator('[data-mobile-menu-button]');
    const menuPanel = page.locator('[data-mobile-menu-panel]');

    await expect(menuButton).toBeVisible();
    await expect(menuPanel).toBeHidden();

    await menuButton.focus();
    await page.keyboard.press('Enter');

    await expect(menuButton).toHaveAttribute('aria-expanded', 'true');
    await expect(menuPanel).toBeVisible();

    await page.keyboard.press('Escape');
    await expect(menuButton).toHaveAttribute('aria-expanded', 'false');
    await expect(menuPanel).toBeHidden();

    await page.setViewportSize({ width: 1440, height: 900 });
    await page.locator('a[href="#contato"]').first().click();
    await expect(page).toHaveURL(/#contato$/);
  });

  test('passes axe accessibility checks in dark theme, light theme, and 404 page', async ({
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

    await page.goto('/404');
    await expect(page.locator('main h1')).toContainText('Página não encontrada');
    const notFoundResults = await new AxeBuilder({ page }).exclude('astro-dev-toolbar').analyze();
    expect(notFoundResults.violations).toEqual([]);
  });
});
