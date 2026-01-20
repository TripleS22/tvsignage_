<?php

namespace App\Filament\Resources\Publishes;

use App\Filament\Resources\Publishes\Pages\CreatePublish;
use App\Filament\Resources\Publishes\Pages\EditPublish;
use App\Filament\Resources\Publishes\Pages\ListPublishes;
use App\Filament\Resources\Publishes\Pages\ViewPublish;
use App\Filament\Resources\Publishes\Schemas\PublishForm;
use App\Filament\Resources\Publishes\Schemas\PublishInfolist;
use App\Filament\Resources\Publishes\Tables\PublishesTable;
use App\Models\Publish;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PublishResource extends Resource
{
    protected static ?string $model = Publish::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Publish';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return PublishForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PublishInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PublishesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPublishes::route('/'),
            'create' => CreatePublish::route('/create'),
            'view' => ViewPublish::route('/{record}'),
            'edit' => EditPublish::route('/{record}/edit'),
        ];
    }
}
