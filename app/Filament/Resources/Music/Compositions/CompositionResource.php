<?php

namespace App\Filament\Resources\Music\Compositions;

use App\Filament\Resources\Music\Compositions\Pages\CreateComposition;
use App\Filament\Resources\Music\Compositions\Pages\EditComposition;
use App\Filament\Resources\Music\Compositions\Pages\ListCompositions;
use App\Filament\Resources\Music\Compositions\Schemas\CompositionForm;
use App\Filament\Resources\Music\Compositions\Tables\CompositionsTable;
use App\Models\Music\Composition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompositionResource extends Resource
{
    protected static ?string $model = Composition::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-musical-note';

    protected static string|\UnitEnum|null $navigationGroup = 'Music';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Compositions';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CompositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompositionsTable::configure($table);
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
            'index' => ListCompositions::route('/'),
            // 'create' => CreateComposition::route('/create'), // Disabled - compositions created via AI generation only
            // 'edit' => EditComposition::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Compositions are created via AI generation, not manually
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
