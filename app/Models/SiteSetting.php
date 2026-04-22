<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'tagline',
        'logo',
        'favicon',
        'default_locale',
        'contact_email',
        'phone',
        'address',
        'social_links',
        'seo_defaults',
    ];

    protected $casts = [
        'site_name' => 'array',
        'tagline' => 'array',
        'address' => 'array',
        'social_links' => 'array',
        'seo_defaults' => 'array',
    ];

    public function getLocalized(string $field, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $value = $this->{$field} ?? [];

        return $value[$locale] ?? $value[config('app.fallback_locale')] ?? null;
    }
}
