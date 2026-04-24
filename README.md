# Kortable

Kortable is a complete **dynamic Laravel portfolio website** with:

- Public front office (portfolio, pages, contact).
- Protected back office (content, settings, users).
- Full localization in **French (`fr`)**, **Arabic (`ar`)**, and **English (`en`)**.
- Language switcher and Arabic RTL rendering.

---

## Tech Stack

- Laravel 10
- PHP 8.2+
- MySQL / MariaDB (or SQLite for tests)
- Blade + Tailwind-style utility classes
- Vite for assets

---

## Local Setup

1. Clone the repository.
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Create environment file:
   ```bash
   cp .env.example .env
   ```
4. Generate app key:
   ```bash
   php artisan key:generate
   ```
5. Configure database in `.env`.
6. Run migrations + seeders:
   ```bash
   php artisan migrate --seed
   ```
7. Build frontend assets:
   ```bash
   npm run build
   ```
   For development watch mode:
   ```bash
   npm run dev
   ```
8. Start local server:
   ```bash
   php artisan serve
   ```

---

## Admin Login (Local Dev)

Seeded demo accounts:

- Super admin: `admin@kortable.test` / `password`
- Editor: `editor@kortable.test` / `password`

Admin URL:

- `http://127.0.0.1:8000/admin/login`

---

## Commands to Run the Project Locally

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Run tests:

```bash
php artisan test
```

---

## Module Overview

### Front Office

- Localized home page with dynamic sections.
- Public projects listing and project detail pages.
- Public CMS pages.
- Contact form with anti-spam protections.
- SEO metadata/canonical support and sitemap/robots endpoints.

### Back Office

- Admin authentication.
- Role/permission based access control.
- Site settings management.
- Content management for pages, projects, project categories, services, testimonials, home sections, and menus.
- Contact message inbox workflow.
- User management (for roles that can manage users).

---

## Localization Overview

- Supported locales: `fr`, `ar`, `en`.
- Route structure is locale-prefixed for front office (e.g. `/fr/projects`, `/ar/projects`, `/en/projects`).
- `/language/{locale}` endpoint updates session locale and redirects to localized equivalent URL.
- Arabic is rendered RTL via locale-aware layout logic.
- Seeded demo content includes multilingual data in all 3 locales.

---

## Demo Data / Seeding Notes

`php artisan migrate --seed` prepares demo-ready data:

- Roles and permissions
- Admin users
- Site settings and menus
- Multilingual pages and home sections
- Project categories and projects (including unpublished sample)
- Services and testimonials
- Contact inbox sample

This allows immediate QA and showcase without manual content entry.

---

## Architecture Summary

- **Routing**
  - `routes/front.php`: localized public routes.
  - `routes/admin.php`: admin routes with auth/admin/permission gates.
  - `routes/localization.php`: language switch endpoint.
- **Middleware**
  - `SetLocale`: resolves locale from route/session and sets app locale.
  - `EnsureAdminUser`: restricts admin area to admin users.
- **Domain models**
  - Content models store translatable payloads as JSON arrays (`fr/ar/en`).
  - Project/page slugs support locale-specific variants.
- **Authorization**
  - Gate-permission mapping from `config/authz.php`.
  - Role-permission linkage seeded by `RolePermissionSeeder`.

---

## Deployment Notes

- Set production `.env` values (`APP_ENV=production`, secure `APP_KEY`, DB/mail/cache/session config).
- Run non-interactive deployment commands:
  ```bash
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan db:seed --class=Database\\Seeders\\DatabaseSeeder --force
  npm ci && npm run build
  php artisan optimize
  ```
- Configure queue worker and scheduler if background jobs/cron are enabled.
- Ensure web server points to `/public` and serves HTTPS.

---

## Quality Control Coverage

Feature tests now cover critical flows:

- Locale switching behavior.
- Admin authentication success/failure.
- Admin access protection and permission gating.
- Public projects listing/detail across locales.
- Contact form submission + anti-spam protections.
- Published vs unpublished project visibility.
- Seeded multilingual content sanity checks.

---

## What Has Been Built vs Optional Future Phases

### Built (Current Phase)

- Complete front + admin structure.
- Dynamic multilingual content model.
- Language switcher + RTL handling.
- Projects showcase and detail flow.
- Contact workflow with admin inbox.
- Role/permission protection.
- Demo-ready seed data and onboarding docs.

### Optional Next Enhancements

1. Media library with upload/crop and reusable assets.
2. Rich text editor with block components for pages/services.
3. Project filtering by tags/technology and search.
4. Audit trail for admin actions.
5. Draft/publish workflow for all content types.
6. API endpoints for headless/mobile consumption.
7. CI pipeline with static analysis + formatting + test matrix.
8. Localization UX polish (localized menu URLs and translated slugs everywhere).
