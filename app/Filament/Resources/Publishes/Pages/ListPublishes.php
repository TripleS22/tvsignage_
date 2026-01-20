<?php

namespace App\Filament\Resources\Publishes\Pages;

use App\Filament\Resources\Publishes\PublishResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPublishes extends ListRecords
{
    protected static string $resource = PublishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
