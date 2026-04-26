# Front Office Redirect + UI Audit (Kortable)

## Scope audited
- Routes: `routes/web.php`, `routes/front.php`, `routes/localization.php`
- Localization middleware: `app/Http/Middleware/SetLocale.php`
- Localized route bindings: `app/Providers/RouteServiceProvider.php`
- Front controllers: page, project, blog show actions
- Front layout and public pages for UX polish and empty-state handling

## Exact redirect loop root cause

### Symptom
Requesting localized content routes such as:
- `/fr/pages/accueil`
- `/fr/projects/{slug}`
- `/fr/blog/{slug}`

resulted in repeated 301 redirects and browser error `ERR_TOO_MANY_REDIRECTS`.

### Chain causing the loop
1. `localizedPage` (and similarly `localizedProject`, `localizedBlogPost`) is route-model bound in `RouteServiceProvider` and becomes an Eloquent model object before reaching the controller.
2. In the show controller actions, canonical slug enforcement compared:
   - `request()->route('localizedPage')` (model object)
   - to `$localizedSlug` (string)
3. This comparison always evaluated as mismatch, so each request triggered a `301` redirect to the same URL.
4. Next request repeated the same logic, creating an infinite redirect cycle.

## Files responsible
- `app/Http/Controllers/Front/PageController.php`
- `app/Http/Controllers/Front/ProjectController.php`
- `app/Http/Controllers/Front/BlogController.php`

## Fix applied

### Canonical check corrected
Updated canonical slug logic to compare the **original raw route parameter** instead of the already-bound model:
- from: `request()->route('localizedPage')`
- to: `request()->route()->originalParameter('localizedPage')`

Same fix applied to project and blog equivalents.

This preserves canonical behavior (redirect wrong slug to correct localized slug), while preventing recursive redirects.

## Route strategy after fix

- Locale home remains: `/{locale}` (`front.home`)
- CMS page route remains: `/{locale}/pages/{localizedPage}` (`front.pages.show`)
- No special redirect between homepage and `pages/accueil` was added.
- This means:
  - `/{locale}` is the homepage route
  - `/fr/pages/accueil` can coexist as a regular CMS page route if present
  - no dual-route loop is introduced by locale middleware or page resolver

## UI/UX improvements implemented

### Design system + layout
- Modernized header with sticky glass effect, cleaner nav, dropdown polish, and responsive mobile menu (Alpine powered).
- Improved footer hierarchy with better fallback content when CMS data is missing.
- Introduced lightweight reveal-on-scroll animation utility via IntersectionObserver (no heavy libs).

### Home/front-office polish
- Upgraded hero section with stronger hierarchy, richer CTAs, subtle motion, and visual depth.
- Improved featured projects, services, testimonials, and CTA block styling.
- Upgraded project index and detail pages with better card rhythm, spacing, and metadata layout.
- Upgraded contact page form and contact info panel with stronger visual consistency.
- Improved generic CMS page presentation.

### Content safety & fallback behavior
- Added non-breaking fallbacks for missing menu/content/settings fields.
- Added graceful empty states for missing dynamic data in key sections/pages.
- Preserved localized rendering and RTL compatibility from existing locale/dir behavior.

## Remaining risks / follow-up
- If business wants strict canonicalization between `/{locale}` and a specific CMS page slug (`accueil`), add a **single direction only** rule and document it to avoid reintroducing loops.
- Consider adding feature tests for canonical redirects on page/project/blog routes to prevent regressions.
- A visual screenshot artifact was not generated in this environment because no browser screenshot tool was available.
