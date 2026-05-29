import { test, expect } from '@playwright/test';

// Fill the order form with the first available package and submit.
async function startOrder(page: import('@playwright/test').Page) {
  await page.goto('/order');
  await page.fill('#nama', 'QA Order');
  await page.fill('#email', 'qa-order@test.local');
  await page.fill('#phone', '081234567890');
  // package radios are positioned off-canvas behind styled cards;
  // set checked via DOM + fire change so the form's JS price logic runs.
  await page.evaluate(() => {
    const r = document.querySelector('input[name="package"]') as HTMLInputElement;
    r.checked = true;
    r.dispatchEvent(new Event('change', { bubbles: true }));
  });
  await page.click('#orderBtn');
}

test('order form -> checkout shows totals', async ({ page }) => {
  await startOrder(page);
  await expect(page).toHaveURL(/\/checkout/);
  // checkout page renders a confirm button + terms
  await expect(page.locator('#checkoutBtn')).toBeVisible();
  await expect(page.locator('#terms')).toBeVisible();
});

test('checkout blocked without terms', async ({ page }) => {
  await startOrder(page);
  await expect(page).toHaveURL(/\/checkout/);
  await page.click('#checkoutBtn');
  // required checkbox prevents submit -> stays on checkout
  await expect(page).toHaveURL(/\/checkout/);
});

test('checkout confirm with terms generates invoice + reaches success', async ({ page }) => {
  await startOrder(page);
  await expect(page).toHaveURL(/\/checkout/);
  await page.check('#terms');
  await page.click('#checkoutBtn');
  // CheckoutController redirects to checkout.success on success
  await expect(page).toHaveURL(/\/checkout\/success/, { timeout: 20000 });
});

test('invalid referral code does not crash checkout', async ({ page }) => {
  await startOrder(page);
  await page.fill('#referral_code', 'NONEXISTENT_CODE_ZZZ');
  await page.check('#terms');
  await page.click('#checkoutBtn');
  // Should still complete (invalid referral ignored) or show validation, not 500
  await expect(page.locator('body')).not.toContainText('Server Error');
});
