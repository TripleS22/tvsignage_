<?php

namespace App\Filament\Resources\Gabungans;

use App\Filament\Resources\Gabungans\Pages\CreateGabungan;
use App\Filament\Resources\Gabungans\Pages\EditGabungan;
use App\Filament\Resources\Gabungans\Pages\ListGabungans;
use App\Filament\Resources\Gabungans\Pages\ViewGabungan;
use App\Filament\Resources\Gabungans\Schemas\GabunganForm;
use App\Filament\Resources\Gabungans\Schemas\GabunganInfolist;
use App\Filament\Resources\Gabungans\Tables\GabungansTable;
use App\Models\Gabungan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GabunganResource extends Resource
{
    protected static ?string $model = Gabungan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Gabungan';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return GabunganForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GabunganInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GabungansTable::configure($table);
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
            'index' => ListGabungans::route('/'),
            'create' => CreateGabungan::route('/create'),
            'view' => ViewGabungan::route('/{record}'),
            'edit' => EditGabungan::route('/{record}/edit'),
        ];
    }
}
