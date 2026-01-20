<?php

namespace App\Filament\Resources\Outlets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OutletInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User')
                    ->placeholder('-'),
                TextEntry::make('kode_outlet'),
                TextEntry::make('nama_outlet'),
                TextEntry::make('gabungan.id')
                    ->label('Gabungan')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('jadwal_mulai')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('jadwal_selesai')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
