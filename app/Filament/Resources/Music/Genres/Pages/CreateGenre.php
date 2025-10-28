<?php

namespace App\Filament\Resources\Music\Genres\Pages;

use App\Filament\Resources\Music\Genres\GenreResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGenre extends CreateRecord
{
    protected static string $resource = GenreResource::class;
}
