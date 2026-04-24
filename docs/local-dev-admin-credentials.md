# Local development admin credentials

Use environment variables to define local seeded admin users. Do **not** commit real credentials.

Set these in your local `.env` before running `php artisan migrate --seed`:

```dotenv
DEV_ADMIN_EMAIL=admin@example.test
DEV_ADMIN_PASSWORD=change-me-now
DEV_EDITOR_EMAIL=editor@example.test
DEV_EDITOR_PASSWORD=change-me-now
```

Notes:

- `AdminUserSeeder` reads the `DEV_*` values and creates/updates users accordingly.
- In production, this seeder does nothing unless `ALLOW_DEMO_ADMIN_SEED=true` is explicitly set.
