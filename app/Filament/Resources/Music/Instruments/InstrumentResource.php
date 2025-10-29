<?php

namespace App\Filament\Resources\Music\Instruments;

use App\Filament\Resources\Music\Instruments\Pages\CreateInstrument;
use App\Filament\Resources\Music\Instruments\Pages\EditInstrument;
use App\Filament\Resources\Music\Instruments\Pages\ListInstruments;
use App\Filament\Resources\Music\Instruments\Schemas\InstrumentForm;
use App\Filament\Resources\Music\Instruments\Tables\InstrumentsTable;
use App\Models\Music\Instrument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InstrumentResource extends Resource
{
    protected static ?string $model = Instrument::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-speaker-wave';

    protected static string|\UnitEnum|null $navigationGroup = 'Music';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Instruments';

    public static function form(Schema $schema): Schema
    {
        return InstrumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstrumentsTable::configure($table);
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
            'index' => ListInstruments::route('/'),
            'create' => CreateInstrument::route('/create'),
            'edit' => EditInstrument::route('/{record}/edit'),
        ];
    }
}
