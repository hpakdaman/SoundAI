<?php

namespace App\Filament\Resources\Music\Genres;

use App\Filament\Resources\Music\Genres\Pages\CreateGenre;
use App\Filament\Resources\Music\Genres\Pages\EditGenre;
use App\Filament\Resources\Music\Genres\Pages\ListGenres;
use App\Filament\Resources\Music\Genres\Schemas\GenreForm;
use App\Filament\Resources\Music\Genres\Tables\GenresTable;
use App\Models\Music\Genre;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-musical-note';

    protected static string|\UnitEnum|null $navigationGroup = 'Music';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Genres';

    protected static ?string $pluralModelLabel = 'Genres';

    protected static ?string $modelLabel = 'Genre';

    public static function form(Schema $schema): Schema
    {
        return GenreForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GenresTable::configure($table);
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
            'index' => ListGenres::route('/'),
            'create' => CreateGenre::route('/create'),
            'edit' => EditGenre::route('/{record}/edit'),
        ];
    }
}
