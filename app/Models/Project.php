<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Models\Concerns\HasLocalizedSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;
    use HasLocalizedSlug;
    use HasTranslatableAttributes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'slug_translations',
        'short_description',
        'description',
        'client_name',
        'project_date',
        'website_url',
        'featured_image',
        'gallery',
        'technologies',
        'is_featured',
        'is_published',
        'sort_order',
        'seo',
        'published_at',
    ];

    protected $casts = [
        'title' => 'array',
        'slug_translations' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'gallery' => 'array',
        'technologies' => 'array',
        'seo' => 'array',
        'project_date' => 'date',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(function (Builder $builder) {
                $builder->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('published_at')->orderByDesc('id');
    }
}
