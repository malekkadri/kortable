<?php

namespace App\Support\Media;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaManager
{
    public static function normalizeStoredPath(?string $path): ?string
    {
        if (! is_string($path)) {
            return null;
        }

        $path = trim($path);
        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        $appUrl = rtrim((string) config('app.url'), '/');
        if ($appUrl !== '' && Str::startsWith($path, $appUrl.'/storage/')) {
            $path = Str::after($path, $appUrl.'/storage/');
        }

        foreach (['/storage/', 'storage/', 'public/', 'storage/app/public/'] as $prefix) {
            if (Str::startsWith($path, $prefix)) {
                $path = Str::after($path, $prefix);
            }
        }

        return ltrim($path, '/');
    }

    public static function url(?string $path, string $placeholder = 'images/placeholders/image.svg'): string
    {
        $normalized = self::normalizeStoredPath($path);

        if (! $normalized) {
            return asset($placeholder);
        }

        if (Str::startsWith($normalized, ['http://', 'https://', '//', 'data:'])) {
            return $normalized;
        }

        if (! Storage::disk('public')->exists($normalized)) {
            return asset($placeholder);
        }

        return Storage::disk('public')->url($normalized);
    }

    public static function deletePublic(?string $path): void
    {
        $normalized = self::normalizeStoredPath($path);

        if (! $normalized || Str::startsWith($normalized, ['http://', 'https://', '//', 'data:'])) {
            return;
        }

        Storage::disk('public')->delete($normalized);
    }
}
