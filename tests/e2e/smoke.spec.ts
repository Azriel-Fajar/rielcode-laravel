import { test, expect } from '@playwright/test';
import { loadFixtures } from './fixtures';

const fixtures = loadFixtures();

test('home loads', async ({ page }) => {
  const resp = await page.goto('/');
  expect(resp?.status()).toBe(200);
});

test('fixtures seeded', async () => {
  expect(fixtures.orderToken).toMatch(/^[a-f0-9]{64}$/);
  expect(fixtures.referrerCode).toBe('QAE2E');
});
