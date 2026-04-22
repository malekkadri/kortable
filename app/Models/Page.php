<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

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
        $value = $this->{$field} ?? [];

        if ($field === 'content' && empty($value)) {
            $value = $this->body ?? [];
        }

        return $value[$locale] ?? $value[config('app.fallback_locale')] ?? null;
    }
}
