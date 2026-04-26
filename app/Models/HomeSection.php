<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Models\Concerns\NormalizesMediaPaths;
use App\Support\Localization\Locale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HomeSection extends Model
{
    use HasFactory;
    use HasTranslatableAttributes;
    use NormalizesMediaPaths;

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
        return $this->getTranslated($attribute, $locale ?? app()->getLocale());
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function localizedCtaLink(?string $locale = null): ?string
    {
        if (! $this->cta_link) {
            return null;
        }

        $locale ??= app()->getLocale();

        if (Str::startsWith($this->cta_link, ['http://', 'https://', '#'])) {
            return $this->cta_link;
        }

        $path = '/'.ltrim($this->cta_link, '/');
        $localePattern = implode('|', Locale::all());

        if (! preg_match('#^/('.$localePattern.')(/|$)#', $path)) {
            $path = '/'.$locale.$path;
        }

        return $path;
    }

    public function setImageAttribute(?string $value): void
    {
        $this->attributes['image'] = $this->normalizeMediaPath($value);
    }
}
