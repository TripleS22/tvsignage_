<?php

namespace App\Filament\Resources\Gabungans\Pages;

use App\Filament\Resources\Gabungans\GabunganResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGabungan extends ViewRecord
{
    protected static string $resource = GabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
