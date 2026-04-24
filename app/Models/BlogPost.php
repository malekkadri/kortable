<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Support\Localization\Locale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    use HasFactory;
    use HasTranslatableAttributes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'slug_translations',
        'excerpt',
        'content',
        'featured_image',
        'is_published',
        'published_at',
        'seo',
    ];

    protected $casts = [
        'title' => 'array',
        'slug_translations' => 'array',
        'excerpt' => 'array',
        'content' => 'array',
        'seo' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(function (Builder $builder) {
                $builder->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
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
