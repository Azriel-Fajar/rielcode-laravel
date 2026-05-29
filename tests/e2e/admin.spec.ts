import { test, expect, type Page } from '@playwright/test';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const HERE = dirname(fileURLToPath(import.meta.url));
const STATE = join(HERE, '.admin-state.json');

const resources = [
  'projects', 'testimonials', 'testimonial-invites', 'orders', 'order-payments',
  'packages', 'package-addons', 'contact-submissions', 'referrers',
  'referral-commissions', 'site-settings', 'chat-logs', 'faqs',
];

// Authenticated session is created in global-setup (.admin-state.json).
test.use({ storageState: STATE });

async function visit(page: Page, path: string) {
  try {
    await page.goto(path, { waitUntil: 'domcontentloaded' });
  } catch (e) {
    if (!String(e).includes('ERR_ABORTED')) throw e;
    await page.waitForLoadState('domcontentloaded');
  }
  await page.waitForLoadState('networkidle');
  expect(page.url(), `failed to reach ${path}`).toContain(path);
}

test('admin dashboard renders', async ({ page }) => {
  await visit(page, '/admin');
  await expect(page.locator('body')).not.toContainText('Server Error');
});

for (const r of resources) {
  test(`admin resource /${r} loads`, async ({ page }) => {
    await visit(page, `/admin/${r}`);
    await expect(page.locator('body')).not.toContainText('Server Error');
    await expect(page.locator('body')).not.toContainText('Whoops, something went wrong');
  });
}

test('audit log page loads', async ({ page }) => {
  await visit(page, '/admin/audit-log');
  await expect(page.locator('body')).not.toContainText('Server Error');
});
