<?php

namespace App\Filament\Resources\Music\Compositions\Pages;

use App\Filament\Resources\Music\Compositions\CompositionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompositions extends ListRecords
{
    protected static string $resource = CompositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
