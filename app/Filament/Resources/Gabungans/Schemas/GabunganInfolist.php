<?php

namespace App\Filament\Resources\Gabungans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GabunganInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User')
                    ->placeholder('-'),
                TextEntry::make('nama_gabungan'),
                TextEntry::make('deskripsi')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('jeda_detik')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                \Filament\Infolists\Components\RepeatableEntry::make('media')
                    ->label('Daftar Media (Sesuai Urutan)')
                    ->schema([
                        \Filament\Infolists\Components\ViewEntry::make('preview')
                            ->view('filament.resources.media.preview'),
                        TextEntry::make('nama_media')
                            ->alignCenter(),
                    ])
                    ->grid(3)
                    ->columnSpanFull(),
            ]);
    }
}
