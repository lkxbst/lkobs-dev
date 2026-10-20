<?php

declare(strict_types=1);

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalhes do Projeto')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Nome do projeto')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, Set $set, Get $get): void {
                                if ($state !== null && ($get('slug') === null || $get('slug') === '')) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('year')
                            ->label('Ano')
                            ->numeric()
                            ->minValue(1990)
                            ->maxValue(2100)
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Ordem')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Textarea::make('description')
                            ->label('Descrição (2 frases)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        TagsInput::make('tags')
                            ->label('Tags')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('live_url')
                            ->label('URL do Projeto (Ver projeto ↗)')
                            ->url()
                            ->nullable()
                            ->maxLength(255),
                        TextInput::make('repo_url')
                            ->label('URL do Repositório (Código ↗)')
                            ->url()
                            ->nullable()
                            ->maxLength(255),
                        Toggle::make('is_published')
                            ->label('Publicado')
                            ->default(true),
                    ]),
                Section::make('Imagem do Projeto (16:10)')
                    ->components([
                        FileUpload::make('image_path')
                            ->label('Captura de tela (otimizada automaticamente para WebP)')
                            ->disk('public')
                            ->directory('projects')
                            ->image()
                            ->imagePreviewHeight('200')
                            ->live(),
                        TextInput::make('image_alt')
                            ->label('Texto alternativo (Alt)')
                            ->required(static fn (Get $get): bool => filled($get('image_path')))
                            ->maxLength(255),
                    ]),
            ]);
    }
}
