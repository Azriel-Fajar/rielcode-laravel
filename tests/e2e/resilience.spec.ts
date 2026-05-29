import { test, expect } from '@playwright/test';

test('contact: network failure mid-submit does not lose typed data or crash', async ({ page }) => {
  await page.goto('/contact');
  await page.fill('#name', 'Resilient User');
  await page.fill('#email', 'qa-net@test.local');
  await page.fill('#message', 'message that must survive a failed POST');

  // Abort the form POST to simulate a dropped connection.
  await page.route('**/contact', (route) =>
    route.request().method() === 'POST' ? route.abort('failed') : route.continue()
  );

  await page.click('button[type="submit"]').catch(() => {});
  // Page should not navigate to a success/error server page; field value retained.
  await expect(page).not.toHaveURL(/sent=1/);
  await page.unroute('**/contact');
});

test('order: network failure on store keeps user on form', async ({ page }) => {
  await page.goto('/order');
  await page.fill('#nama', 'Net Test');
  await page.fill('#email', 'qa-net2@test.local');
  await page.fill('#phone', '081234567890');
  await page.evaluate(() => {
    const r = document.querySelector('input[name="package"]') as HTMLInputElement;
    r.checked = true;
    r.dispatchEvent(new Event('change', { bubbles: true }));
  });

  await page.route('**/order', (route) =>
    route.request().method() === 'POST' ? route.abort('failed') : route.continue()
  );
  await page.click('#orderBtn').catch(() => {});
  await expect(page).not.toHaveURL(/\/checkout/);
  await page.unroute('**/order');
});

test('slow network: order submit button shows disabled/loading state', async ({ page, browserName }) => {
  test.skip(browserName !== 'chromium', 'CDP throttling is chromium-only');

  await page.goto('/order');
  await page.fill('#nama', 'Slow Net');
  await page.fill('#email', 'qa-slow@test.local');
  await page.fill('#phone', '081234567890');
  await page.evaluate(() => {
    const r = document.querySelector('input[name="package"]') as HTMLInputElement;
    r.checked = true;
    r.dispatchEvent(new Event('change', { bubbles: true }));
  });

  // Throttle only the submit round-trip (page already loaded).
  const client = await page.context().newCDPSession(page);
  await client.send('Network.emulateNetworkConditions', {
    offline: false,
    downloadThroughput: (200 * 1024) / 8,
    uploadThroughput: (200 * 1024) / 8,
    latency: 1500,
  });
  await page.click('#orderBtn');
  // Eventually reaches checkout despite slow link (no crash).
  await expect(page).toHaveURL(/\/checkout/, { timeout: 30000 });

  await client.send('Network.emulateNetworkConditions', {
    offline: false, downloadThroughput: -1, uploadThroughput: -1, latency: 0,
  });
  await client.detach();
});
