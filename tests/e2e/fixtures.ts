import { readFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const HERE = dirname(fileURLToPath(import.meta.url));

export type QaFixtures = {
  orderId: number;
  orderToken: string;
  inviteToken: string;
  referrerCode: string;
  invoiceNumber: string;
  adminEmail: string;
  adminPass: string;
};

export function loadFixtures(): QaFixtures {
  return JSON.parse(readFileSync(join(HERE, '.qa-fixtures.json'), 'utf8'));
}
