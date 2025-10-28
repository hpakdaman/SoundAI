<?php

namespace App\Filament\Resources\Music\Compositions\Pages;

use App\Filament\Resources\Music\Compositions\CompositionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditComposition extends EditRecord
{
    protected static string $resource = CompositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
