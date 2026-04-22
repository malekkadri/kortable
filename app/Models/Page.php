<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'status',
        'title',
        'excerpt',
        'body',
    ];

    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'body' => 'array',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getLocalized(string $field, string $locale): ?string
    {
        $value = $this->{$field} ?? [];

        return $value[$locale] ?? $value[config('app.fallback_locale')] ?? null;
    }
}
