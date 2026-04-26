<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Models\Concerns\HasLocalizedSlug;
use App\Models\Concerns\NormalizesMediaPaths;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use HasLocalizedSlug;
    use HasTranslatableAttributes;
    use NormalizesMediaPaths;

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
        return $query->where('status', 'published')
            ->where('is_active', true)
            ->where(function ($builder) {
                $builder->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function getLocalized(string $field, string $locale): ?string
    {
        if ($field === 'content' && empty($this->content)) {
            return $this->getTranslated('body', $locale);
        }

        return $this->getTranslated($field, $locale);
    }

    public function setFeaturedImageAttribute(?string $value): void
    {
        $this->attributes['featured_image'] = $this->normalizeMediaPath($value);
    }

    public function setSeoAttribute(?array $value): void
    {
        if (is_array($value) && isset($value['og_image'])) {
            $value['og_image'] = $this->normalizeMediaPath($value['og_image']);
        }

        $this->attributes['seo'] = json_encode($value ?? []);
    }
}
