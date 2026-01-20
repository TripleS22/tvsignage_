<?php

namespace App\Filament\Resources\Publishes\Pages;

use App\Filament\Resources\Publishes\PublishResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPublish extends ViewRecord
{
    protected static string $resource = PublishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
