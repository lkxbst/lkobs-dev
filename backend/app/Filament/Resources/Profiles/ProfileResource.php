<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles;

use App\Filament\Resources\Profiles\Pages\EditProfile;
use App\Filament\Resources\Profiles\Schemas\ProfileForm;
use App\Models\Profile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $navigationLabel = 'Perfil';

    protected static ?string $modelLabel = 'Perfil';

    protected static ?string $pluralModelLabel = 'Perfil';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ProfileForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditProfile::route('/'),
        ];
    }
}
