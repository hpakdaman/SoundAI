<?php

namespace App\Filament\Resources\Music\Instruments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InstrumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->helperText('Auto-generated from name, but you can customize it.'),

                Select::make('category')
                    ->options([
                        'keys' => 'Keys',
                        'strings' => 'Strings',
                        'percussion' => 'Percussion',
                        'wind' => 'Wind',
                        'electronic' => 'Electronic',
                        'vocal' => 'Vocal',
                        'other' => 'Other',
                    ])
                    ->required()
                    ->searchable()
                    ->helperText('Category helps organize instruments by type.'),

                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                Textarea::make('prompt_keywords')
                    ->rows(3)
                    ->helperText('Keywords to enhance AI prompt generation. Leave blank to use the name.')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Only active instruments will be available for music generation.'),

                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first.'),
            ])
            ->columns(2);
    }
}
