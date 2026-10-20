<?php

declare(strict_types=1);

namespace App\Filament\Resources\SocialLinks\Pages;

use App\Filament\Actions\PublishSiteAction;
use App\Filament\Resources\SocialLinks\SocialLinkResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialLinks extends ListRecords
{
    protected static string $resource = SocialLinkResource::class;

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
