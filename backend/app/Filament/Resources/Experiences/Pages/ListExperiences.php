<?php

declare(strict_types=1);

namespace App\Filament\Resources\Experiences\Pages;

use App\Filament\Actions\PublishSiteAction;
use App\Filament\Resources\Experiences\ExperienceResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExperiences extends ListRecords
{
    protected static string $resource = ExperienceResource::class;

    /**
     * @return array<Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            PublishSiteAction::make(),
        ];
    }
}
