import { execSync } from 'node:child_process';
import { existsSync, readFileSync, rmSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const HERE = dirname(fileURLToPath(import.meta.url));
const ROOT = join(HERE, '..', '..');
const FIX = join(HERE, '.qa-fixtures.json');

export default function globalTeardown() {
  if (!existsSync(FIX)) return;
  const data = JSON.parse(readFileSync(FIX, 'utf8'));
  // Order delete cascades to access tokens, progress notes, payments.
  const php = `
    App\\Models\\Order::where('id', ${data.orderId})->delete();
    App\\Models\\TestimonialInvite::where('token', '${data.inviteToken}')->delete();
    App\\Models\\Referrer::where('code', '${data.referrerCode}')->delete();
    App\\Models\\User::where('email', '${data.adminEmail}')->delete();
    echo 'QA_TEARDOWN_OK';
  `.replace(/\n/g, ' ');
  const out = execSync(`php artisan tinker --execute="${php.replace(/"/g, '\\"')}"`, {
    cwd: ROOT,
    encoding: 'utf8',
  });
  if (!out.includes('QA_TEARDOWN_OK')) {
    console.warn('global-teardown: cleanup may have failed:\n' + out);
  }
  rmSync(FIX, { force: true });
  rmSync(join(HERE, '.admin-state.json'), { force: true });
  console.log('QA fixtures cleaned up.');
}
