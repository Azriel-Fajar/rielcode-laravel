import { test, expect } from '@playwright/test';

const pages = [
  '/', '/work', '/services', '/studio', '/contact',
  '/privacy', '/terms', '/sitemap.xml',
];

for (const path of pages) {
  test(`public page ${path} returns 200`, async ({ page }) => {
    const resp = await page.goto(path);
    expect(resp?.status(), `GET ${path}`).toBe(200);
  });
}

test('work detail loads first project', async ({ page }) => {
  await page.goto('/work');
  const firstCard = page.locator('a[href^="/work/"]').first();
  const count = await firstCard.count();
  test.skip(count === 0, 'no projects to open (empty state)');
  await firstCard.click();
  await expect(page).toHaveURL(/\/work\/.+/);
});
