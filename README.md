# Kortable

Kortable is a dynamic Laravel portfolio website with:

- Public front office (portfolio, pages, contact).
- Protected back office (content, settings, users).
- Localization in **French (`fr`)**, **Arabic (`ar`)**, and **English (`en`)**.
- Language switcher and Arabic RTL rendering.

---

## Tech Stack

- Laravel 10
- PHP 8.2+
- MySQL / MariaDB (SQLite supported for testing)
- Blade + utility-style CSS
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
6. (Optional) Configure local seeded admin credentials in `.env`:
   ```dotenv
   DEV_ADMIN_EMAIL=admin@example.test
   DEV_ADMIN_PASSWORD=change-me-now
   DEV_EDITOR_EMAIL=editor@example.test
   DEV_EDITOR_PASSWORD=change-me-now
   ```
7. Run migrations + seeders:
   ```bash
   php artisan migrate --seed
   ```
8. Link storage for public uploads:
   ```bash
   php artisan storage:link
   ```
9. Build frontend assets:
   ```bash
   npm run build
   ```
   For development watch mode:
   ```bash
   npm run dev
   ```
10. Start local server:
    ```bash
    php artisan serve
    ```

---

## Environment Configuration Expectations

Use environment-specific values and never commit real credentials.

### Core App

- `APP_ENV=production` in production.
- `APP_DEBUG=false` in production.
- Set a valid `APP_KEY` (`php artisan key:generate --force` when bootstrapping environment).
- Set `APP_URL` to your canonical HTTPS URL.

### Database

- Configure `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Run migrations during deployment (`php artisan migrate --force`).
- Seed only if your release process requires baseline content.

### Mail

- Use `MAIL_MAILER` and provider-neutral SMTP/API settings as needed.
- Set `MAIL_FROM_ADDRESS` and `MAIL_FROM_NAME`.
- If mail transport is unavailable, contact submissions are still persisted and app UX remains successful.

### Queues (if used)

- Default connection can remain `sync` for simple deployments.
- If switching to async workers, configure `QUEUE_CONNECTION` and worker/supervisor on your host.
- Run failed-job table migration if using background jobs:
  ```bash
  php artisan queue:table
  php artisan migrate --force
  ```

### Cache & Config Optimization

Run these during production deployment:

```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

For rollback/troubleshooting:

```bash
php artisan optimize:clear
```

---

## Storage and Asset Handling

- User-uploaded/public files should use the `public` disk and require `php artisan storage:link`.
- Frontend assets are built with Vite and emitted to `public/build` via `npm run build`.
- Do not rely on hot-reload/dev server in production.
- Ensure your web server serves from `/public`.

---

## Deployment Checklist (Provider-Agnostic)

1. Copy code and install runtime dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm ci
   npm run build
   ```
2. Configure production `.env` (`APP_ENV`, `APP_DEBUG`, DB, mail, cache/session, queue).
3. Generate/set `APP_KEY` and set canonical `APP_URL`.
4. Run database migration safely:
   ```bash
   php artisan migrate --force
   ```
5. Link storage:
   ```bash
   php artisan storage:link
   ```
6. Run Laravel optimization commands:
   ```bash
   php artisan optimize
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
7. Restart PHP workers/processes and queue workers if applicable.
8. Verify health checks, logs, and a full front + admin smoke test.

---

## Security Notes

- No fixed development credentials are hard-coded for seeded admin users.
- Local seeded credentials can be set through `DEV_*` env variables.
- In production, admin demo-user seeding is skipped unless explicitly enabled.

---

## Commands to Run Locally

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run dev
php artisan serve
```

Run tests:

```bash
php artisan test
```
