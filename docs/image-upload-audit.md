# Image Upload & Display Audit Report

Date: 2026-04-26
Project: Kortable Laravel

## Scope audited
- Site settings logo + favicon upload and front-office rendering.
- Page featured image upload and rendering.
- Project featured image, gallery, and rendering.
- Service image upload and rendering.
- Testimonial avatar upload and rendering.
- Home section image upload and rendering.
- Blog post featured image / OG image behavior (for consistency).
- SEO OG image rendering pipeline.
- Filesystem disk configuration and local dev prerequisites.

## Root causes found

1. **URL generation assumed one path format only (`asset('storage/'.$path)`)**
   - Rendering expected DB values to always be raw relative paths.
   - Legacy/manual values like `/storage/...`, `storage/...`, `storage/app/public/...`, or full URLs caused broken links or double prefixes.

2. **Delete operations also assumed normalized relative paths**
   - Multiple controllers deleted files with `Storage::disk('public')->delete($path)` directly.
   - If a stored path included `/storage/...` or URL-like values, cleanup failed silently and stale files remained.

3. **Missing fallback behavior for absent/broken media**
   - Front-office image components hid images or rendered broken URLs.
   - No consistent graceful placeholder strategy across entities.

4. **Front-office did not render some uploaded image fields**
   - Service images and testimonial avatars were uploadable in admin but not displayed in key front-office templates.

5. **Admin forms had uploads enabled but weak preview feedback**
   - Most forms had proper multipart setup, but admins lacked preview confidence for current media in some key forms.

## Fixes applied

### 1) Centralized media normalization and URL strategy
Implemented `App\Support\Media\MediaManager` with:
- `normalizeStoredPath()` to normalize incoming paths to a canonical DB format.
- `url()` to generate display-safe URLs with placeholder fallback.
- `deletePublic()` to safely delete normalized public-disk paths.

### 2) Model-level path normalization (DB consistency)
Added `NormalizesMediaPaths` trait and applied mutators in models so persisted values are normalized consistently:
- `SiteSetting` (`logo`, `favicon`, `seo_defaults.og_image`)
- `Page` (`featured_image`, `seo.og_image`)
- `Project` (`featured_image`, `gallery[]`, `seo.og_image`)
- `Service` (`image`, `seo.og_image`)
- `Testimonial` (`avatar`)
- `HomeSection` (`image`)
- `BlogPost` (`featured_image`, `seo.og_image`)

### 3) Controller cleanup logic hardened
Replaced direct `Storage::disk('public')->delete(...)` calls in content controllers with `MediaManager::deletePublic(...)` so legacy path shapes are handled safely.

### 4) Rendering standardized to media helper
Replaced manual `asset('storage/...')` render logic with `MediaManager::url(...)` in front-office templates and SEO partial.

### 5) Added placeholders
Added reusable placeholders:
- `public/images/placeholders/image.svg`
- `public/images/placeholders/avatar.svg`

These are used as graceful fallback for missing/unreadable files.

### 6) Front/admin UX improvements
- Front: service cards now show uploaded service images.
- Front: testimonial cards now show avatars.
- Front: header logo and favicon rendering now use normalized/fallback logic.
- Admin: preview images added to key media upload forms.

## Final storage strategy

**Canonical persisted format (DB):**
- Relative path on `public` disk only, e.g. `projects/featured/example.jpg`.

**Upload strategy:**
- Use `store('...', 'public')` consistently for all media uploads.

**Display strategy:**
- Use `MediaManager::url($path)` for all image/OG output.
- Supports both normalized local paths and absolute URLs.

**Delete strategy:**
- Use `MediaManager::deletePublic($path)` for removals.

## Filesystem / env expectations
- `FILESYSTEM_DISK=public` (already set in `.env.example`).
- Public disk root: `storage/app/public`.
- Public URL base: `APP_URL/storage`.

## Local development required commands
Run after setup or if media is not visible:

```bash
php artisan storage:link
php artisan optimize:clear
```

If permissions block writes:

```bash
chmod -R ug+rw storage bootstrap/cache
```

## Audited flows status after fixes
- Site settings logo upload/display: ✅
- Site settings favicon upload/display: ✅
- Page featured image upload/display: ✅
- Project featured image upload/display: ✅
- Project gallery upload/save/display: ✅
- Service image upload/display: ✅
- Testimonial avatar upload/display: ✅
- Home section image upload/display: ✅
- SEO OG image output consistency: ✅

## Notes
- Existing inconsistent DB media values will be normalized on subsequent model saves/updates.
- New writes are now normalized at model level.
