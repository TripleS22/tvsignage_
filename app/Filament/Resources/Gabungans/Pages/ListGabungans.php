<?php

namespace App\Filament\Resources\Gabungans\Pages;

use App\Filament\Resources\Gabungans\GabunganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGabungans extends ListRecords
{
    protected static string $resource = GabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
