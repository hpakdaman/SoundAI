<?php

namespace App\Filament\Resources\Music\Compositions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CompositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('genre.name')
                    ->searchable(),
                TextColumn::make('custom_genre')
                    ->searchable(),
                TextColumn::make('custom_vibe')
                    ->searchable(),
                TextColumn::make('tempo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('duration')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('key_signature')
                    ->searchable(),
                TextColumn::make('time_signature')
                    ->searchable(),
                TextColumn::make('prompt_pattern_used')
                    ->searchable(),
                TextColumn::make('audio_file_path')
                    ->searchable(),
                TextColumn::make('file_size')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('file_format')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('processing_time')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cost_estimate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('privacy')
                    ->badge(),
                IconColumn::make('featured')
                    ->boolean(),
                TextColumn::make('play_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('download_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('like_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
