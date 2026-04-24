<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Models\Concerns\HasLocalizedSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use HasLocalizedSlug;
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

}
