# Security & Bug Review — rielcode-laravel — 2026-05-29

## Executive summary
Whole-codebase static audit (deep-review skill, 5 parallel domain agents). Overall risk: **moderate-to-high** —
two HIGH access-control issues and one HIGH price-manipulation issue, all real and reachable. Counts:
**3 High, 4 Medium, 6 Low**. Scope: full codebase (vendor/build excluded). Dynamic Playwright verification:
**off** — HIGH findings carry PoC recipes but are marked `Static`; run a dev server + re-run with the dynamic
tier to confirm. Confidence threshold: 70 (lower-confidence items noted under Low/awareness).

## Findings

### High

#### H1. `is_admin` authorization never enforced on Filament admin panel — confidence 88 — Static
- **Location:** `app/Providers/Filament/AdminPanelProvider.php:79-81`, `app/Models/User.php:11`
- **Why it matters:** Panel `authMiddleware` is only `Authenticate`. `User` does not implement `FilamentUser`/`canAccessPanel()`, so Filament's default grants every authenticated user full admin (orders, payments, customer PII, site settings, referral payouts). The `is_admin` column exists but is checked nowhere — dead flag, false sense of role separation. Mitigated only by there being no public registration route.
- **Fix:** Implement `FilamentUser` on `User`: `public function canAccessPanel(Panel $panel): bool { return (bool) $this->is_admin; }`; cast `is_admin` to boolean.

#### H2. Invoice enumeration / IDOR on `/i/{invoiceNumber}` — confidence 85 — Static
- **Location:** `app/Http/Controllers/PublicInvoiceController.php:14-16,30-32`; numbers minted at `CheckoutController.php:90`, `app/Services/InvoiceNumberService.php:22`
- **Why it matters:** Invoice page + PDF have no auth/token, looked up purely by `invoice_number`. Numbers are predictable (`INV-{Ymd}-{orderId}` / `INV-{year}-{NNN}-{D|F}`, sequential). Attacker iterates the id space and harvests every invoice's name, email, phone, package, amount, payment status.
- **PoC:** `GET /i/INV-20260529-1`, `/i/INV-20260529-2`, … (and `/pdf` variants) — no cookie/token required.
- **Fix:** Gate behind an unguessable token (reuse `OrderAccessToken` / `token.gate:order`) or add a high-entropy `public_slug` (`bin2hex(random_bytes(16))`) and route on that; keep the human-readable number for display only.

#### H3. Client-controlled Custom Plan total (price manipulation) — confidence 90 — Static
- **Location:** `app/Http/Controllers/CustomPlanController.php:65`, consumed at `CheckoutController.php:153`
- **Why it matters:** Custom Plan price is computed in client JS and submitted via hidden `custom_total` input (`resources/views/pages/custom-plan.blade.php:270`). Server only enforces a `min:500000` floor and never recomputes from selected `custom_config`. Buyer dictates their own invoice price down to the floor regardless of features ordered. (Standard plans are safe — server-derived from `pkg->idr_price`.)
- **PoC:** On `/custom-plan` enable e-commerce + CMS + extra pages (JS shows e.g. Rp4.000.000), set `#form-custom-total` to `500000` in devtools, submit → checkout confirms `final_price = 500000`.
- **Fix:** Recompute the total server-side from `custom_config` against authoritative per-feature prices; ignore the client value or validate it equals the server sum before persisting/invoicing.

### Medium

#### M1. Unescaped user fields in dompdf invoice HTML — confidence 80 — Static
- **Location:** `app/Services/InvoicePdfService.php:69,80,81,91`
- **Why it matters:** `invoice_number`, `order_name`, `email`, `package` (user-supplied via `/order`) are interpolated into the PDF heredoc without `e()`. HTML/CSS injection into generated invoices. Held to Medium: dompdf defaults (`isRemoteEnabled`/`isPhpEnabled` = false, no `config/dompdf.php` override) prevent SSRF/local-file-read/RCE; input lengths are capped by `StoreOrderRequest`.
- **Fix:** Wrap each interpolated DB string in `e()` before building the heredoc.

#### M2. `$guarded = []` on Project, Testimonial, ContactSubmission — confidence 75 — Static
- **Location:** `app/Models/Project.php:11`, `app/Models/Testimonial.php:11`, `app/Models/ContactSubmission.php:11`
- **Why it matters:** All columns mass-assignable. Not currently exploited (only `ContactSubmission::create` is request-fed, from a fixed validated whitelist), but latent: any future `::create($request->all())` could let an attacker set `status` (testimonial approval), `is_visible`, or override `created_at`.
- **Fix:** Replace `$guarded = []` with explicit `$fillable` per model.

#### M3. Referral commission derived from manipulable final price — confidence 70 — Static
- **Location:** `app/Http/Controllers/CheckoutController.php:104-110`
- **Why it matters:** `commissionAmount = finalPrice * rate/100`, created at confirm time before any payment is verified. For Custom Plan, `finalPrice` flows from attacker-controlled `custom_total` (H3); a colluding referrer+buyer can inflate payable commission.
- **Fix:** Tie commission to a verified/paid invoice amount (or admin-approved value); recompute from authoritative pricing (depends on H3).

#### M4. No security response headers — confidence 70 — Static
- **Location:** project-wide (no security-headers middleware)
- **Why it matters:** No CSP, HSTS, X-Frame-Options, X-Content-Type-Options. Clickjacking + MIME-sniffing exposure on public site and token-gated portals.
- **Fix:** Add a global middleware setting `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, a baseline CSP; enable HSTS at the web server in prod.

### Low

- **L1. Testimonial token gate lacks format floor** — conf 55 — `app/Http/Middleware/TokenGate.php:73-94`. Unlike the order path (`/^[a-f0-9]{64}$/`), testimonial only checks non-empty + `<=128` chars. Real tokens are `Str::random(64)` (strong) and lookup is exact-match, so not currently exploitable; missing format floor is a defense-in-depth gap. Fix: `preg_match('/^[A-Za-z0-9]{64}$/', $token)` before querying.
- **L2. Admin "Generate Progress Token" produces tokens the gate rejects** — conf 70 — `app/Filament/Resources/OrderResource.php:151` vs `TokenGate.php:53`. `Str::random(64)` (mixed case) fails the `/^[a-f0-9]{64}$/` gate → 403. Functional bug + inconsistent generation. Fix: use `bin2hex(random_bytes(32))` to match checkout.
- **L3. Confirm flow double-submit race** — conf 55 — `CheckoutController.php:64-118`. Read-then-write status guard with no lock/transaction; concurrent confirms can duplicate `pkg->increment('orders')`, commission rows, tokens, emails. Fix: wrap in transaction with `lockForUpdate`, or conditional `update()->where('status','Pending')` and proceed only if 1 row affected.
- **L4. Silent confirmation-email failure** — conf 60 — `CheckoutController.php:123-136`. Mail failure is logged but flow proceeds to success; progress token only in session, so if email never arrives and session expires the customer loses their portal link. Fix: surface a user-visible warning and/or re-send from admin (token row already persisted).
- **L5. `APP_DEBUG=true` in committed `.env.example`** — conf 90 — `.env.example:4`. Real `.env` is gitignored and `config/app.php` defaults debug to false; risk is a deployer copying the example. Fix: ship `APP_DEBUG=false`/`APP_ENV=production` in the example.
- **L6. Stored-XSS sink `{!! $row['label'] !!}`** — conf 45 — `resources/views/pages/home.blade.php:137`, `services.blade.php:64`. Renders `features_json` unescaped; source is admin-managed via Filament (trusted), so exploitable only by a malicious/compromised admin. Fix: use `{{ }}` unless raw HTML is intentional and admin-only is an accepted trust boundary.

### Awareness (below threshold, not findings)
- Chat endpoint has no per-message length cap (`ChatController`) — bounded by the 30k token/day budget; consider `max:2000` on `message`.
- No `TrustProxies` override (correct today) — but behind a CDN/LB without configuring trusted proxies, all visitors collapse to the proxy IP and the chat rate limiter throttles everyone together. Flag for deployment.

## Scope & cost note
- Files reviewed across 5 domains (routes/controllers, models/db, auth/middleware, services, config) — `vendor/`, `node_modules/`, build artifacts excluded.
- Subagents: 5 parallel (security/injection, auth/access, database/data, logic/bugs, config/secrets); bulk file reading stayed in subagent contexts, only compact findings returned to main thread.
- Confirmed clean: parameterized raw SQL throughout (RateLimiter, ReferrerController, InvoiceNumberService, widgets); no `unserialize`/`eval`/`exec`/user-controlled `Http::get`; OpenAI URL fixed (no SSRF); standard-plan pricing server-derived; CSRF/session via framework defaults; no committed secrets/hardcoded keys.
- Dynamic verification: **off**. H1/H2/H3 PoCs are runnable against a local dev server — start the app and re-run deep-review's dynamic tier to mark them `Confirmed (dynamic)`.
