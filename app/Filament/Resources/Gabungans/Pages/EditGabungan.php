<?php

namespace App\Filament\Resources\Gabungans\Pages;

use App\Filament\Resources\Gabungans\GabunganResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGabungan extends EditRecord
{
    protected static string $resource = GabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
