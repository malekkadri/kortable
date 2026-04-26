<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableAttributes;
use App\Models\Concerns\NormalizesMediaPaths;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    use HasTranslatableAttributes;
    use NormalizesMediaPaths;

    protected $fillable = [
        'author_name',
        'author_role',
        'company',
        'content',
        'avatar',
        'rating',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'author_role' => 'array',
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function setAvatarAttribute(?string $value): void
    {
        $this->attributes['avatar'] = $this->normalizeMediaPath($value);
    }
}
