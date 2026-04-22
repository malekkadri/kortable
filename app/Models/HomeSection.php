<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    public const TYPE_HERO = 'hero';
    public const TYPE_ABOUT_INTRO = 'about_intro';
    public const TYPE_FEATURED_PROJECTS = 'featured_projects';
    public const TYPE_SERVICES = 'services';
    public const TYPE_TESTIMONIALS = 'testimonials';
    public const TYPE_CTA_BLOCK = 'cta_block';

    protected $fillable = [
        'section_type',
        'section_key',
        'title',
        'subtitle',
        'content',
        'image',
        'cta_label',
        'cta_link',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'content' => 'array',
        'cta_label' => 'array',
        'is_active' => 'boolean',
    ];

    public static function sectionTypes(): array
    {
        return config('kortable.home_sections.types', []);
    }

    public function getLocalized(string $attribute, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $values = $this->{$attribute} ?? [];
        $fallback = config('kortable.default_locale', 'en');

        if (! is_array($values)) {
            return $values;
        }

        return $values[$locale] ?? $values[$fallback] ?? null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
