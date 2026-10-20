<?php

declare(strict_types=1);

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('role')
                    ->label('Cargo')
                    ->required()
                    ->maxLength(255),
                TextInput::make('company')
                    ->label('Empresa')
                    ->required()
                    ->maxLength(255),
                TextInput::make('start_year')
                    ->label('Ano de início')
                    ->numeric()
                    ->minValue(1990)
                    ->maxValue(2100)
                    ->required(),
                TextInput::make('end_year')
                    ->label('Ano de término (vazio = hoje)')
                    ->numeric()
                    ->minValue(1990)
                    ->maxValue(2100)
                    ->nullable(),
                TextInput::make('impact')
                    ->label('Impacto (1 linha)')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->label('Ordem')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_published')
                    ->label('Publicado')
                    ->default(true),
            ]);
    }
}
