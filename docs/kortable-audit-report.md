# Kortable Architecture Audit Report

Date: 2026-04-24

## Confirmed good parts

- Locale catalog is already centralized and constrained to `fr`, `ar`, `en` in `config/kortable.php`.
- Front office locale-prefixed routing (`/{locale}/...`) is already in place.
- Admin routes are isolated under `/admin` and protected by dedicated middleware.
- Dynamic homepage section rendering already relies on `home_sections` type-to-view mapping.
- Core content modules (pages, projects, blog) already support JSON-translated fields.

## Detected problems, risk, and applied fixes

| Area | Problem | Risk | Fix applied |
|---|---|---|---|
| Localization | `SetLocale` always injected URL locale defaults globally, including admin/non-localized routes. | Medium | Limited URL defaults to `front.*` routes and clear defaults elsewhere. |
| Localization / i18n consistency | Some modules manually read translated arrays with hardcoded `en` fallback while others use shared translation helpers. | Medium | Normalized models/views to use shared translation concern (`HasTranslatableAttributes`) for `HomeSection`, `Service`, `Testimonial`, and updated affected Blade views. |
| Slugs / URLs | Page route used ad-hoc slug lookup in controller while project/blog used route model binding. | Medium | Added `localizedPage` route binding and switched page route/controller to same localized binding strategy used by blog/projects. |
| Slugs / URLs | Page, project, blog had duplicated localized slug resolution logic. | Low | Added shared `HasLocalizedSlug` concern and reused it across those entities. |
| Slugs / URLs | Services had no localized slug storage while pages/projects/blog did. | Medium | Added `slug_translations` to services (migration), model casts/fillables, request validation/normalization, and admin form inputs. |
| Publish filtering | Page/project/blog visibility checks were not fully consistent for `published_at`. | Medium | Extended `Page::published()` and `Project::published()` to honor publication date windows; tightened show-page checks in front controllers. |
| Category URL strategy | Project/blog category filtering behavior differed and included fragile localized-name matching in projects. | Low | Normalized both to stable category slug filtering with active category constraint. |
| Admin authorization UX | Admin sidebar mixed unrelated links under `manage_pages`, while routes use separate abilities. | Low | Aligned nav rendering with route-level abilities (`manage_projects`, `manage_services`, `manage_menus`). |
| SEO URL generation | Sitemap still generated legacy pages route parameter name. | Low | Updated sitemap links to new localized page route parameter. |

## Notes on scope

- Refactoring was incremental and backward-compatible where practical.
- No new packages were introduced.
- Existing route names were preserved.
- Schema change for services is additive and nullable to avoid data breakage.
