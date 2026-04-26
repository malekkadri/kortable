<?php

namespace App\Models\Concerns;

use App\Support\Media\MediaManager;

trait NormalizesMediaPaths
{
    protected function normalizeMediaPath(?string $value): ?string
    {
        return MediaManager::normalizeStoredPath($value);
    }

    protected function normalizeMediaArray(?array $values): array
    {
        return collect($values ?? [])
            ->map(fn ($value) => MediaManager::normalizeStoredPath($value))
            ->filter()
            ->values()
            ->all();
    }
}
