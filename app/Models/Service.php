<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedSlug;
use App\Models\Concerns\HasTranslatableAttributes;
use App\Models\Concerns\NormalizesMediaPaths;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    use HasLocalizedSlug;
    use HasTranslatableAttributes;
    use NormalizesMediaPaths;

    protected $fillable = [
        'title',
        'slug',
        'slug_translations',
        'short_description',
        'description',
        'icon',
        'image',
        'is_active',
        'sort_order',
        'seo',
    ];

    protected $casts = [
        'title' => 'array',
        'slug_translations' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'seo' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function setImageAttribute(?string $value): void
    {
        $this->attributes['image'] = $this->normalizeMediaPath($value);
    }

    public function setSeoAttribute(?array $value): void
    {
        if (is_array($value) && isset($value['og_image'])) {
            $value['og_image'] = $this->normalizeMediaPath($value['og_image']);
        }

        $this->attributes['seo'] = json_encode($value ?? []);
    }
}
