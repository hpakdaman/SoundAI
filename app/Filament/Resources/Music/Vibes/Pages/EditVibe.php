<?php

namespace App\Filament\Resources\Music\Vibes\Pages;

use App\Filament\Resources\Music\Vibes\VibeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVibe extends EditRecord
{
    protected static string $resource = VibeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
