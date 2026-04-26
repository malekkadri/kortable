<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Support\Localization\Locale;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'label',
        'type',
        'linked_page_id',
        'linked_blog_category_id',
        'custom_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'label' => 'array',
        'is_active' => 'boolean',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'linked_page_id');
    }

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'linked_blog_category_id');
    }

    public function resolveUrl(string $locale): ?string
    {
        if ($this->type === 'page' && $this->page) {
            $localizedSlug = $this->page->localizedSlug($locale);

            return route('front.pages.show', ['locale' => $locale, 'localizedPage' => $localizedSlug]);
        }

        if ($this->type === 'blog_index') {
            return route('front.blog.index', ['locale' => $locale]);
        }

        if ($this->type === 'blog_category' && $this->blogCategory) {
            return route('front.blog.index', ['locale' => $locale, 'category' => $this->blogCategory->slug]);
        }

        if (empty($this->custom_url)) {
            return null;
        }

        if (Str::startsWith($this->custom_url, '#')) {
            return $this->custom_url;
        }

        if (Str::startsWith($this->custom_url, ['http://', 'https://'])) {
            return $this->custom_url;
        }

        $path = '/'.ltrim($this->custom_url, '/');

        $localePattern = implode('|', Locale::all());

        if (! preg_match('#^/('.$localePattern.')(/|$)#', $path)) {
            $path = '/'.$locale.$path;
        }

        return url($path);
    }
}
