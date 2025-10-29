<?php

namespace App\Filament\Resources\Music\Vibes;

use App\Filament\Resources\Music\Vibes\Pages\CreateVibe;
use App\Filament\Resources\Music\Vibes\Pages\EditVibe;
use App\Filament\Resources\Music\Vibes\Pages\ListVibes;
use App\Filament\Resources\Music\Vibes\Schemas\VibeForm;
use App\Filament\Resources\Music\Vibes\Tables\VibesTable;
use App\Models\Music\Vibe;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VibeResource extends Resource
{
    protected static ?string $model = Vibe::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    protected static string|\UnitEnum|null $navigationGroup = 'Music';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Vibes';

    public static function form(Schema $schema): Schema
    {
        return VibeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VibesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVibes::route('/'),
            'create' => CreateVibe::route('/create'),
            'edit' => EditVibe::route('/{record}/edit'),
        ];
    }
}
