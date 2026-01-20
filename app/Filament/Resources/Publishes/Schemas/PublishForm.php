<?php

namespace App\Filament\Resources\Publishes\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PublishForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('outlet_id')
                    ->relationship('outlet', 'nama_outlet')
                    ->required()
                    ->searchable(),
                Select::make('gabungan_id')
                    ->label('Media Composition')
                    ->relationship('gabungan', 'nama_gabungan')
                    ->required()
                    ->searchable(),
                Toggle::make('is_online')
                    ->required(),
                DateTimePicker::make('last_ping'),
                DateTimePicker::make('published_at'),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published', 'stopped' => 'Stopped'])
                    ->default('draft')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
