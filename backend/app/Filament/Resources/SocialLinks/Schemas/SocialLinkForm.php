<?php

declare(strict_types=1);

namespace App\Filament\Resources\SocialLinks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->label('Rótulo')
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->label('URL')
                    ->url()
                    ->required()
                    ->maxLength(255),
                Toggle::make('show_in_hero')
                    ->label('Exibir no Hero')
                    ->default(true),
                Toggle::make('show_in_contact')
                    ->label('Exibir no Contato')
                    ->default(true),
                TextInput::make('sort_order')
                    ->label('Ordem')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
