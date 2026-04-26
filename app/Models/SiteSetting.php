<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Models\Concerns\NormalizesMediaPaths;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;
    use HasTranslatableAttributes;
    use NormalizesMediaPaths;

    protected $fillable = [
        'site_name',
        'tagline',
        'logo',
        'favicon',
        'default_locale',
        'contact_email',
        'phone',
        'address',
        'map_embed_url',
        'social_links',
        'seo_defaults',
        'footer_content',
    ];

    protected $casts = [
        'site_name' => 'array',
        'tagline' => 'array',
        'address' => 'array',
        'social_links' => 'array',
        'seo_defaults' => 'array',
        'footer_content' => 'array',
    ];

    public function getLocalized(string $field, ?string $locale = null): ?string
    {
        return $this->getTranslated($field, $locale);
    }

    public function setLogoAttribute(?string $value): void
    {
        $this->attributes['logo'] = $this->normalizeMediaPath($value);
    }

    public function setFaviconAttribute(?string $value): void
    {
        $this->attributes['favicon'] = $this->normalizeMediaPath($value);
    }

    public function setSeoDefaultsAttribute(?array $value): void
    {
        if (is_array($value) && isset($value['og_image'])) {
            $value['og_image'] = $this->normalizeMediaPath($value['og_image']);
        }

        $this->attributes['seo_defaults'] = json_encode($value ?? []);
    }
}
