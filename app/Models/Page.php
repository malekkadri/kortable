<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Support\Localization\Locale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use HasTranslatableAttributes;

    protected $fillable = [
        'slug',
        'slug_translations',
        'status',
        'title',
        'excerpt',
        'body',
        'content',
        'featured_image',
        'is_active',
        'template',
        'sort_order',
        'seo',
        'published_at',
    ];

    protected $casts = [
        'slug_translations' => 'array',
        'title' => 'array',
        'excerpt' => 'array',
        'body' => 'array',
        'content' => 'array',
        'seo' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_active', true);
    }

    public function getLocalized(string $field, string $locale): ?string
    {
        if ($field === 'content' && empty($this->content)) {
            return $this->getTranslated('body', $locale);
        }

        return $this->getTranslated($field, $locale);
    }

    public function localizedSlug(?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $fallback = Locale::fallback();

        return $this->slug_translations[$locale]
            ?? $this->slug_translations[$fallback]
            ?? $this->slug;
    }
}
