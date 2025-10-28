<?php

namespace App\Filament\Resources\Music\Instruments\Pages;

use App\Filament\Resources\Music\Instruments\InstrumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInstrument extends EditRecord
{
    protected static string $resource = InstrumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
