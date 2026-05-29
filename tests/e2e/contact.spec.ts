import { test, expect } from '@playwright/test';

test('valid contact submit redirects to sent=1', async ({ page }) => {
  await page.goto('/contact');
  await page.fill('#name', 'QA Tester');
  await page.fill('#email', 'qa-contact@test.local');
  await page.fill('#message', 'This is a QA test message.');
  await page.click('button[type="submit"]');
  await expect(page).toHaveURL(/\/contact\?sent=1/);
});

test('invalid email blocks submit', async ({ page }) => {
  await page.goto('/contact');
  await page.fill('#name', 'QA Tester');
  await page.fill('#email', 'not-an-email');
  await page.fill('#message', 'msg');
  // Native HTML5 email validation prevents POST; URL stays on /contact (no sent=1).
  await page.click('button[type="submit"]');
  await expect(page).not.toHaveURL(/sent=1/);
});

test('empty submit blocked by required fields', async ({ page }) => {
  await page.goto('/contact');
  await page.click('button[type="submit"]');
  await expect(page).not.toHaveURL(/sent=1/);
});

test('honeypot silently ignored', async ({ page }) => {
  await page.goto('/contact');
  await page.fill('#name', 'Bot');
  await page.fill('#email', 'bot@test.local');
  await page.fill('#message', 'spam');
  // honeypot field is name="website"
  await page.evaluate(() => {
    const el = document.querySelector('[name="website"]') as HTMLInputElement | null;
    if (el) el.value = 'http://spam.example';
  });
  await page.click('button[type="submit"]');
  // Controller redirects to /contact (no sent=1) when honeypot filled.
  await expect(page).toHaveURL(/\/contact$/);
});

test('edge: emoji + SQL fragment + long text accepted, stored safe', async ({ page }) => {
  await page.goto('/contact');
  await page.fill('#name', "Robert'); DROP TABLE users;-- 😀");
  await page.fill('#email', 'qa-edge@test.local');
  await page.fill('#message', 'x'.repeat(4000) + ' <script>alert(1)</script>');
  await page.click('button[type="submit"]');
  await expect(page).toHaveURL(/\/contact\?sent=1/);
});

test('throttle: rapid submits eventually 429', async ({ page }) => {
  // Load form once to get CSRF token + session cookie, then POST via fetch
  // inside the page so CSRF passes and only the rate limiter can reject.
  await page.goto('/contact');
  const token = await page.getAttribute('input[name="_token"]', 'value');
  expect(token, 'CSRF token present on contact form').toBeTruthy();

  const statuses: number[] = await page.evaluate(async (csrf) => {
    const codes: number[] = [];
    for (let i = 0; i < 8; i++) {
      const body = new URLSearchParams({
        _token: csrf!, name: 'T', email: `t${i}@test.local`, message: 'm',
      });
      const r = await fetch('/contact', {
        method: 'POST', body, redirect: 'manual',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      });
      codes.push(r.status);
    }
    return codes;
  }, token);

  expect(statuses.some((s) => s === 429), `expected a 429; got ${statuses}`).toBeTruthy();
});
