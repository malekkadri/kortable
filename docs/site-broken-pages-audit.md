# Kortable Broken Pages & Features Audit

Date: 2026-04-26

## Scope covered
- Front office route coverage and rendering behavior.
- Admin route authorization and content-management flows.
- Dynamic content dependencies (seeding and publish-state behavior).
- Localization, locale-aware URLs, and menu/CTA link correctness.

## Broken / empty routes found

| Area | Route(s) | Symptom | Root cause | Severity | Fix applied |
|---|---|---|---|---|---|
| Front office | `/{locale}/services` | Missing page for services content | No front route/controller/view existed for services listing | High | Added `front.services.index` route, new `Front\\ServiceController@index`, and `resources/views/front/services/index.blade.php` with empty-state fallback |
| Front office | `/{locale}/about` | No direct about route (only dynamic `/pages/{slug}`), causing navigation inconsistency | Route alias missing for core page expected by product intent | Medium | Added `front.about` route and `PageController::about()` redirecting to localized dynamic page slug |
| Front office home CTA blocks | Hero / Featured projects / CTA block section links | Broken links or wrong locale links (e.g., static `/fr/...` or unlocalized `/projects`) | CTA links rendered raw from DB without locale-aware normalization | High | Added `HomeSection::localizedCtaLink()` and switched home-section blades to use it |
| Front office home featured projects | Home section cards | Cards had no detail-page link, reducing flow usability | Incomplete view wiring | Medium | Added localized project detail links in featured projects section |
| Front office header/footer menus | Menu custom links like `/projects`, `/services` | Links could resolve to non-localized paths and 404/redirect unpredictably | `MenuItem::resolveUrl()` converted custom URLs using `url()` without locale prefixing | High | Updated URL resolver to preserve anchors/external URLs and auto-prefix locale for internal custom paths |
| Admin content forms | Admin menu CRUD and menu-item CRUD | Authorized route access could still fail on submit with 403 in certain permission setups | `StoreMenuRequest` and `StoreMenuItemRequest` used wrong permission (`manage_pages`) instead of `manage_menus` | High | Updated request authorization to `manage_menus` |
| Admin service CRUD | Admin services create/update | Authorized route access could still fail on submit with 403 in certain permission setups | `StoreServiceRequest` used wrong permission (`manage_pages`) instead of `manage_services` | High | Updated request authorization to `manage_services` |
| Seeded navigation realism | Header/footer menu dataset | Menu included weak placeholder links (`#services`, nested `SEO`) and missed direct primary links | Seeder content not aligned with real user journeys | Medium | Rebuilt `MenuSeeder` demo menu items to include usable Home/About/Projects/Services/Blog/Contact links |
| Seeded home CTA link | Home CTA to contact | Hard-coded `/fr/pages/contact` forced French on all locales | Locale-specific hardcoded path in seed data | High | Updated `HomeSectionSeeder` CTA to locale-neutral `/contact` (now localized at render time) |
| Seeded admin access | `/admin/login` after fresh seed | Demo login not practical because seeded passwords were random by default | Seeder used generated random passwords unless env vars set | High | Updated default seeded credentials to deterministic dev-safe values (`Admin@123456`, `Editor@123456`) with env override support |

## Additional findings

- The repository currently cannot be fully booted in this environment because dependencies could not be downloaded (network restrictions to GitHub while running `composer install`).
- `composer.json` constraints were out-of-sync with `composer.lock` (Laravel 9 constraints in JSON vs Laravel 10 lock). This prevents normal installation and likely explains some “it doesn’t run” complaints in fresh environments.

## Installation/runtime blocker remediation applied

- Updated `composer.json` constraints to align with the existing lockfile major versions (`laravel/framework` 10, PHPUnit 10, Collision 7, Ignition 2, PHP 8.1 baseline).
- This removes the immediate manifest/lock mismatch error; full install remains environment-dependent on network access.

## Verification status

### Verified in this environment
- Static code audit across front/admin routes, controllers, views, models, and seeders.
- PHP syntax validation on all changed PHP files.

### Not fully verified due to environment limits
- Full Laravel runtime boot (`artisan`), migrations/seeding execution, feature tests, HTTP route responses in-browser.
- Reason: dependency installation failed due to blocked GitHub connectivity during `composer install`.

## Expected result after environment with normal package access

After `composer install`, `php artisan migrate:fresh --seed`, and serving the app:
- Public routes now include explicit About and Services pages.
- Home section CTAs and menu links resolve to locale-aware URLs.
- Header/footer navigation is populated with realistic working demo links.
- Admin menu and services forms authorize consistently with their route permissions.
- Seeded content is immediately usable for fr/ar/en demo browsing.
