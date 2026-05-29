import { test, expect } from '@playwright/test';
import { loadFixtures } from './fixtures';

const fx = loadFixtures();

test('invoice HTML page loads 200', async ({ page }) => {
  const resp = await page.goto(`/i/${fx.invoiceNumber}`);
  expect(resp?.status()).toBe(200);
});

test('invoice PDF returns application/pdf', async ({ request }) => {
  const resp = await request.get(`/i/${fx.invoiceNumber}/pdf`);
  expect(resp.status()).toBe(200);
  expect(resp.headers()['content-type']).toContain('pdf');
  const body = await resp.body();
  expect(body.length).toBeGreaterThan(500);
});

test('unknown invoice -> 404', async ({ page }) => {
  const resp = await page.goto('/i/INV-DOES-NOT-EXIST');
  expect(resp?.status()).toBe(404);
});

// Helper: get CSRF token from a page that has @csrf, then POST via in-page fetch.
async function postChat(page: import('@playwright/test').Page, message: string) {
  await page.goto('/contact');
  const token = await page.getAttribute('input[name="_token"]', 'value');
  return page.evaluate(async ({ csrf, msg }) => {
    const r = await fetch('/api/chat', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf!,
        'Accept': 'application/json',
      },
      body: JSON.stringify({ message: msg }),
    });
    return { status: r.status, json: await r.json() };
  }, { csrf: token, msg: message });
}

test('chat identity question short-circuits (no API spend)', async ({ page }) => {
  const res = await postChat(page, 'who are you?');
  expect(res.status).toBe(200);
  expect(res.json.ok).toBe(true);
  expect(typeof res.json.reply).toBe('string');
  expect(res.json.reply.length).toBeGreaterThan(0);
});

test('chat empty message -> 400 RC-CHAT-001', async ({ page }) => {
  const res = await postChat(page, '');
  expect(res.status).toBe(400);
  expect(res.json.code).toBe('RC-CHAT-001');
});

test('chat live question returns a reply', async ({ page }) => {
  test.slow();
  const res = await postChat(page, 'In one short sentence, what services does Rielcode offer?');
  expect(res.status).toBe(200);
  expect(res.json.ok).toBe(true);
  expect(res.json.reply.length).toBeGreaterThan(0);
});
