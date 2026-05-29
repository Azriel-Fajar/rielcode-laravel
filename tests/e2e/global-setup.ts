import { execSync } from 'node:child_process';
import { writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import { chromium } from '@playwright/test';

const HERE = dirname(fileURLToPath(import.meta.url));
const ROOT = join(HERE, '..', '..');
const BASE = 'http://127.0.0.1:8000';

// PHP one-liner: seed throwaway QA fixtures, echo a single JSON line prefixed QAJSON:
const php = `
$pkg = App\\Models\\Package::first();
$order = App\\Models\\Order::create([
  'order_name'=>'QA E2E','email'=>'qa-e2e@test.local','phone_number'=>'08123',
  'package'=>$pkg->package_name,'package_id'=>$pkg->id,'status'=>'On Progress',
  'invoice_number'=>'INV-QAE2E','description'=>'qa','final_price'=>1000,
]);
$tok = bin2hex(random_bytes(32));
App\\Models\\OrderAccessToken::create(['order_id'=>$order->id,'token'=>$tok]);
$invNo = 'INV-QAE2E-'.$order->id;
App\\Models\\OrderPayment::create(['order_id'=>$order->id,'stage'=>'deposit','invoice_number'=>$invNo,'amount'=>500000,'currency'=>'IDR','status'=>'sent','due_date'=>now()->addDays(7)->toDateString()]);
App\\Models\\OrderProgressNote::create(['order_id'=>$order->id,'note'=>'QA progress note visible to client']);
$inviteTok = bin2hex(random_bytes(32));
App\\Models\\TestimonialInvite::create(['token'=>$inviteTok,'label'=>'QA E2E']);
$ref = App\\Models\\Referrer::firstOrCreate(['code'=>'QAE2E'],['name'=>'QA Ref','phone'=>'08123','status'=>'active']);
$admin = App\\Models\\User::updateOrCreate(
  ['email'=>'qa-admin@test.local'],
  ['name'=>'QA Admin','password'=>bcrypt('qapass123'),'is_admin'=>true]
);
echo 'QAJSON:'.json_encode([
  'orderId'=>$order->id,'orderToken'=>$tok,
  'inviteToken'=>$inviteTok,'referrerCode'=>$ref->code,
  'invoiceNumber'=>$invNo,
  'adminEmail'=>'qa-admin@test.local','adminPass'=>'qapass123',
]).PHP_EOL;
`.replace(/\n/g, ' ');

export default async function globalSetup() {
  const out = execSync(`php artisan tinker --execute="${php.replace(/"/g, '\\"')}"`, {
    cwd: ROOT,
    encoding: 'utf8',
  });
  const line = out.split('\n').find((l) => l.startsWith('QAJSON:'));
  if (!line) throw new Error('global-setup: no QAJSON line in tinker output:\n' + out);
  const data = JSON.parse(line.slice('QAJSON:'.length));
  writeFileSync(join(HERE, '.qa-fixtures.json'), JSON.stringify(data, null, 2));
  console.log('QA fixtures seeded:', data.orderId);

  // Log into Filament once and persist the authenticated session for admin specs.
  const browser = await chromium.launch();
  const page = await browser.newPage({ baseURL: BASE });
  await page.goto('/admin/login');
  await page.fill('input[type="email"]', data.adminEmail);
  await page.fill('input[type="password"]', data.adminPass);
  await Promise.all([
    page.waitForURL(/\/admin($|\/)/, { timeout: 20000 }),
    page.click('button[type="submit"]'),
  ]);
  await page.waitForLoadState('networkidle');
  await page.context().storageState({ path: join(HERE, '.admin-state.json') });
  await browser.close();
  console.log('Admin session persisted.');
}
