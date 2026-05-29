# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Admin Performance Notes

- Dashboard widgets cache their queries for 60s (`Cache::remember('widget.*', 60, ...)`) and are lazy-loaded (`$isLazy = true`). With `CACHE_STORE=database`, those cache hits still touch MySQL.
- **Redis follow-up (biggest lever, not yet done):** XAMPP ships without Redis. Once Redis is installed, set `CACHE_STORE=redis`, `SESSION_DRIVER=redis`, `QUEUE_CONNECTION=redis` in `.env` — this removes the per-request DB roundtrips for cache/session that currently dominate admin load cost.
- **Production:** ensure `APP_DEBUG=false` in prod `.env` (currently `true` for local dev) — debug mode adds error/query overhead.

## Commands

```bash
# First-time setup
composer run setup

# Start full dev environment (server + queue + logs + Vite)
composer run dev

# Individual processes
php artisan serve
npm run dev

# Build assets for production
npm run build

# Run migrations
php artisan migrate

# Lint PHP (Laravel Pint)
./vendor/bin/pint

# Run tests
php artisan test
php artisan test --filter TestClassName
```

## Architecture

Portfolio + agency commerce site — server-rendered Laravel 12, no API routes (except `/api/chat*`).

**Request flow**: Route → Controller → Blade view (with Tailwind + GSAP)

### Content Sources

Two parallel content systems:
1. **Database**: Projects and Testimonials — queried via Eloquent scopes `Project::visible()`, `Testimonial::approved()`
2. **Markdown files** (`resources/content/`): Services and FAQs — loaded by `ServicesController` using a custom YAML frontmatter parser (no external YAML library)

### Controllers → Views

| Controller | Route | Notes |
|---|---|---|
| `HomeController` | `/` | `pages/home` |
| `WorkController` | `/work`, `/work/{slug}` | portfolio |
| `ServicesController` | `/services` | reads markdown content |
| `StudioController` | `/studio` | `pages/studio` |
| `ContactController` | `/contact` | GET + POST, throttled 5/min |
| `OrderController` | `/order` | order creation + email resume |
| `CheckoutController` | `/checkout` | order confirmation flow |
| `CustomPlanController` | `/custom-plan` | bespoke enquiry form |
| `ClientBriefController` | `/brief` | token-gated |
| `ProgressController` | `/progress` | token-gated |
| `TestimonialController` | `/testimonial` | token-gated |
| `ReferrerController` | `/referrer` | token-gated (code=) |
| `PublicInvoiceController` | `/i/{invoiceNumber}` | public invoice + PDF |
| `ChatController` | `/api/chat`, `/api/chat/stream` | AI chatbot |
| `PageController` | `/privacy`, `/terms`, `/sitemap.xml` | static |

### Token-Gated Portals

`TokenGate` middleware (`token.gate:{type}`) guards client-facing portals. Token passed as `?t=` (hex-64 for orders, string for testimonials) or `?code=` (referrer). Sets `token.gate.row` and `token.gate.type` on the request for downstream controllers. Three types: `order`, `testimonial`, `referrer`.

### Admin Panel (Filament)

Filament 3 at `/admin`. Resources under `app/Filament/Resources/` cover: Projects, Testimonials, TestimonialInvites, Orders, OrderPayments, Packages, PackageAddons, ContactSubmissions, Referrers, ReferralCommissions, SiteSettings, ChatLogs, Faqs. Custom page: `AuditLog`. Widgets: ChatVolume, OrderStatus, PendingTestimonials, UnpaidCommissions.

### Site Settings

`SiteSetting::get($key)` — cached (5 min), type-aware (`image` → Storage URL, `json` → decoded array). Managed via Filament's SiteSettings resource. Cache auto-busted on save/delete.

### Order Flow

`/order` (form) → `OrderController::store` creates Order + `OrderAccessToken` (hex-64) → confirmation email with token links → `/brief?t=`, `/progress?t=`, `/testimonial?t=` portals. Payments tracked via `OrderPayment` (deposit/final stages). Invoice PDF via dompdf at `/i/{number}/pdf`.

### Referral System

`Referrer` model with unique `code`. Orders linked via `referral_code` field. `ReferralCommission` tracks per-order commission. Portal at `/referrer?code=`.

### View Layer

- Base layout: `resources/views/components/layouts/base.blade.php`
- Shared components: `nav`, `footer`, `theme-toggle`
- Vite entry points: `resources/css/app.css`, `resources/js/app.js`, `resources/js/case-study.js`
- CSS organized as: `tokens.css` → `global.css` → `components.css` → `app.css`

### Database Models

Most models have `$timestamps = false` (Order, Project, Testimonial, etc.) — `created_at` is manually managed where needed.

### Frontend

GSAP (`motion.js`, `case-study.js`) handles animations. `nav-burger.js` and `theme-toggle.js` are standalone scripts. Tailwind CSS 4 via Vite plugin.

---

## Behavioral Guidelines (Karpathy)

**Tradeoff:** These guidelines bias toward caution over speed. For trivial tasks, use judgment.

### 1. Think Before Coding
- State assumptions explicitly. If uncertain, ask.
- If multiple interpretations exist, present them — don't pick silently.
- If a simpler approach exists, say so. Push back when warranted.
- If something is unclear, stop. Name what's confusing. Ask.

### 2. Simplicity First
- Minimum code that solves the problem. Nothing speculative.
- No features beyond what was asked.
- No abstractions for single-use code.
- No "flexibility" or "configurability" that wasn't requested.
- No error handling for impossible scenarios.
- If you write 200 lines and it could be 50, rewrite it.

### 3. Surgical Changes
- Touch only what you must. Clean up only your own mess.
- Don't "improve" adjacent code, comments, or formatting.
- Don't refactor things that aren't broken.
- Match existing style, even if you'd do it differently.
- If you notice unrelated dead code, mention it — don't delete it.
- Remove only imports/variables/functions that YOUR changes made unused.
- Every changed line should trace directly to the user's request.

### 4. Goal-Driven Execution
- Define success criteria. Loop until verified.
- For multi-step tasks, state a brief plan with verification steps.
