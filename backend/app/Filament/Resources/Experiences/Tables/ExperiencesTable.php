<?php

declare(strict_types=1);

namespace App\Filament\Resources\Experiences\Tables;

use App\Models\Experience;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('role')
                    ->label('Cargo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('company')
                    ->label('Empresa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('period')
                    ->label('Período')
                    ->state(static fn (Experience $record): string => $record->formattedPeriod()),
                ToggleColumn::make('is_published')
                    ->label('Publicado'),
                TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
