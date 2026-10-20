<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Jobs\TriggerFrontendRebuild;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class PublishSiteAction
{
    public static function make(): Action
    {
        return Action::make('publishSite')
            ->label('Publicar site agora')
            ->icon(Heroicon::OutlinedRocketLaunch)
            ->color('primary')
            ->requiresConfirmation()
            ->modalHeading('Publicar site agora')
            ->modalDescription('Isso disparará imediatamente a reconstrução e publicação do site estático.')
            ->modalSubmitActionLabel('Publicar agora')
            ->action(function (): void {
                TriggerFrontendRebuild::dispatchSync('manual_admin_action');

                Notification::make()
                    ->title('Publicação disparada com sucesso!')
                    ->body('O rebuild do site foi solicitado e registrado no log.')
                    ->success()
                    ->send();
            });
    }
}
