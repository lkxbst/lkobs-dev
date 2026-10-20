<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Actions\PublishSiteAction;
use App\Filament\Resources\Profiles\ProfileResource;
use App\Models\Profile;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    public function mount(int|string|null $record = null): void
    {
        $profile = Profile::singleton();

        parent::mount($profile->getKey());
    }

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
