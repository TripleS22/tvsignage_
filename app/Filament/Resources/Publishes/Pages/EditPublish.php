<?php

namespace App\Filament\Resources\Publishes\Pages;

use App\Filament\Resources\Publishes\PublishResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPublish extends EditRecord
{
    protected static string $resource = PublishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
