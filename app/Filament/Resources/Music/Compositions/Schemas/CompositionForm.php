<?php

namespace App\Filament\Resources\Music\Compositions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required(),
                Select::make('genre_id')
                    ->relationship('genre', 'name'),
                TextInput::make('custom_genre'),
                TextInput::make('custom_vibe'),
                TextInput::make('custom_instruments'),
                TextInput::make('tempo')
                    ->numeric(),
                TextInput::make('duration')
                    ->numeric(),
                TextInput::make('key_signature'),
                TextInput::make('time_signature'),
                Textarea::make('style_keywords')
                    ->columnSpanFull(),
                Textarea::make('full_prompt')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('prompt_pattern_used')
                    ->required()
                    ->default('standard'),
                TextInput::make('generation_parameters'),
                TextInput::make('audio_file_path'),
                TextInput::make('waveform_data'),
                TextInput::make('file_size')
                    ->numeric(),
                TextInput::make('file_format'),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
        ])
                    ->default('pending')
                    ->required(),
                Textarea::make('error_message')
                    ->columnSpanFull(),
                TextInput::make('processing_time')
                    ->numeric(),
                TextInput::make('cost_estimate')
                    ->numeric(),
                Select::make('privacy')
                    ->options(['public' => 'Public', 'private' => 'Private', 'unlisted' => 'Unlisted'])
                    ->default('public')
                    ->required(),
                Toggle::make('featured')
                    ->required(),
                TextInput::make('play_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('download_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('like_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
