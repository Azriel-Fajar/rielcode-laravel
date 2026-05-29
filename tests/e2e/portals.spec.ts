import { test, expect } from '@playwright/test';
import { loadFixtures } from './fixtures';

const fx = loadFixtures();

test('brief portal loads with valid order token', async ({ page }) => {
  const resp = await page.goto(`/brief?t=${fx.orderToken}`);
  expect(resp?.status()).toBe(200);
  // form present only if brief not yet submitted; either way must be 200, no error
  await expect(page.locator('body')).not.toContainText('Server Error');
});

// Mutates the shared fixture (sets brief_submitted_at) -> chromium only so
// other browser projects still see an unsubmitted brief.
test('brief submit sets submitted + redirects to thanks, then re-visit short-circuits', async ({ page }, testInfo) => {
  test.skip(testInfo.project.name !== 'chromium', 'mutates fixture; chromium only');
  await page.goto(`/brief?t=${fx.orderToken}`);
  for (const id of ['business', 'goals', 'audience', 'success', 'brand_style']) {
    await page.fill(`#${id}`, `QA ${id} answer`);
  }
  await page.click('#briefSubmit');
  await expect(page).toHaveURL(/\/brief\/thanks/, { timeout: 20000 });

  // re-visit submitted brief -> controller returns thanks view (no form)
  await page.goto(`/brief?t=${fx.orderToken}`);
  await expect(page.locator('#business')).toHaveCount(0);
});

test('progress portal loads + shows seeded progress note', async ({ page }) => {
  const resp = await page.goto(`/progress?t=${fx.orderToken}`);
  expect(resp?.status()).toBe(200);
  await expect(page.locator('body')).toContainText('QA progress note visible to client');
});

test('testimonial portal loads with valid invite token', async ({ page }) => {
  const resp = await page.goto(`/testimonial?t=${fx.inviteToken}`);
  expect(resp?.status()).toBe(200);
  await expect(page.locator('#client_name')).toBeVisible();
});

test('referrer portal loads with valid code', async ({ page }) => {
  const resp = await page.goto(`/referrer?code=${fx.referrerCode}`);
  expect(resp?.status()).toBe(200);
});

test('malformed order token -> 403', async ({ page }) => {
  const resp = await page.goto('/brief?t=not-a-valid-hex-token');
  expect(resp?.status()).toBe(403);
});

test('missing order token -> 403', async ({ page }) => {
  const resp = await page.goto('/brief');
  expect(resp?.status()).toBe(403);
});

test('invalid referrer code -> 403', async ({ page }) => {
  const resp = await page.goto('/referrer?code=NOPE_INVALID');
  expect(resp?.status()).toBe(403);
});
