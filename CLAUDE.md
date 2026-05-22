# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
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

Portfolio/agency site — server-rendered Laravel 12, no API routes.

**Request flow**: Route → Controller → Blade view (with Tailwind + GSAP)

### Content Sources

Two parallel content systems:
1. **Database**: Projects (`projects` table) and Testimonials — queried via Eloquent scopes `Project::visible()`, `Testimonial::approved()`
2. **Markdown files** (`resources/content/`): Services and FAQs — loaded by `ServicesController` using a custom YAML frontmatter parser (no external YAML library)

### Controllers → Views

| Controller | View path |
|---|---|
| `HomeController` | `pages/home` |
| `WorkController` | `pages/work/index`, `pages/work/show` |
| `ServicesController` | `pages/services` |
| `StudioController` | `pages/studio` |
| `ContactController` | `pages/contact` (GET + POST, throttled 5/min) |
| `PageController` | `pages/privacy`, `pages/terms`, `pages/sitemap` |

### View Layer

- Base layout: `resources/views/components/layouts/base.blade.php`
- Shared components: `nav`, `footer`, `theme-toggle`
- Vite entry points: `resources/css/app.css`, `resources/js/app.js`, `resources/js/case-study.js`
- CSS organized as: `tokens.css` → `global.css` → `components.css` → `app.css`

### Database Models

`User`, `Project`, `Testimonial`, `ContactSubmission` — Project and Testimonial have no timestamps by design.

Contact form submissions trigger `ContactSubmission` mailable via `app/Mail/`.

### Frontend

GSAP (`motion.js`, `case-study.js`) handles animations. `nav-burger.js` and `theme-toggle.js` are standalone scripts. Tailwind CSS 4 via Vite plugin.
