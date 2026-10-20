<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\TriggerFrontendRebuild;
use App\Models\Project;
use App\Services\PortfolioPayloadService;
use App\Services\ProjectImageOptimizer;
use Illuminate\Database\Eloquent\Model;

class PortfolioCacheObserver
{
    public function __construct(
        private readonly ProjectImageOptimizer $imageOptimizer,
    ) {}

    public function saving(Model $model): void
    {
        if ($model instanceof Project && $model->isDirty('image_path')) {
            $imagePath = $model->image_path;

            if ($imagePath !== null && $imagePath !== '') {
                $optimized = $this->imageOptimizer->optimizePublicImage($imagePath);

                if ($optimized !== null) {
                    $model->image_path = $optimized['path'];
                    $model->image_width = $optimized['width'];
                    $model->image_height = $optimized['height'];
                }
            } else {
                $model->image_width = null;
                $model->image_height = null;
            }
        }
    }

    public function saved(Model $model): void
    {
        PortfolioPayloadService::invalidateCache();
        TriggerFrontendRebuild::dispatch('model_saved:'.class_basename($model))
            ->delay(now()->addSeconds(60));
    }

    public function deleted(Model $model): void
    {
        PortfolioPayloadService::invalidateCache();
        TriggerFrontendRebuild::dispatch('model_deleted:'.class_basename($model))
            ->delay(now()->addSeconds(60));
    }
}
