<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'is_translatable',
    ];

    protected $casts = [
        'value' => 'array',
        'is_translatable' => 'boolean',
    ];
}
