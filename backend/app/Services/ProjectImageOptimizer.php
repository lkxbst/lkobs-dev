<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProjectImageOptimizer
{
    public const MAX_WIDTH = 1600;

    /**
     * Optimizes an image on the 'public' disk into WebP (max 1600px width)
     * and returns its final path, width, and height.
     *
     * @return array{path: string, width: int, height: int}|null
     */
    public function optimizePublicImage(string $relativePath): ?array
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($relativePath)) {
            return null;
        }

        $absolutePath = $disk->path($relativePath);
        $manager = new ImageManager(new Driver);
        $image = $manager->read($absolutePath);

        if ($image->width() > self::MAX_WIDTH) {
            $image->scaleDown(width: self::MAX_WIDTH);
        }

        $width = $image->width();
        $height = $image->height();

        $webpPath = preg_replace('/\.[a-zA-Z0-9]+$/', '.webp', $relativePath);
        if (! is_string($webpPath) || ! Str::endsWith($webpPath, '.webp')) {
            $webpPath = $relativePath.'.webp';
        }

        $encoded = $image->toWebp(quality: 85);
        $disk->put($webpPath, (string) $encoded);

        if ($webpPath !== $relativePath) {
            $disk->delete($relativePath);
        }

        return [
            'path' => $webpPath,
            'width' => $width,
            'height' => $height,
        ];
    }
}
