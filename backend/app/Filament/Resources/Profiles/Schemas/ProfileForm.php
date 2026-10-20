<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identidade e Hero')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('handle')
                            ->label('Handle (logo)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('city')
                            ->label('Cidade')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('E-mail público')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_available')
                            ->label('Disponível para novos projetos')
                            ->default(true),
                        TextInput::make('availability_label')
                            ->label('Texto de disponibilidade')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('headline')
                            ->label('Headline (Hero)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('headline_highlight')
                            ->label('Trecho em destaque na Headline')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
                Section::make('Sobre e Ferramentas')
                    ->components([
                        Textarea::make('about_primary')
                            ->label('Sobre — Parágrafo principal')
                            ->required()
                            ->rows(4),
                        Textarea::make('about_secondary')
                            ->label('Sobre — Parágrafo secundário')
                            ->required()
                            ->rows(4),
                        TagsInput::make('tools')
                            ->label('Ferramentas')
                            ->required(),
                    ]),
                Section::make('Currículo (PDF)')
                    ->components([
                        FileUpload::make('resume_path')
                            ->label('Arquivo PDF do Currículo (máx. 5 MB)')
                            ->disk('public')
                            ->directory('resumes')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->downloadable()
                            ->openable(),
                    ]),
            ]);
    }
}
