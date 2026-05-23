# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

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
