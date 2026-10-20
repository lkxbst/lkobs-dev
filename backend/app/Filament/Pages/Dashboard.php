<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Actions\PublishSiteAction;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * @return array<Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            PublishSiteAction::make(),
        ];
    }
}
