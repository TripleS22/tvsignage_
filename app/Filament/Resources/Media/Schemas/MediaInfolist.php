<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MediaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User')
                    ->placeholder('-'),
                \Filament\Infolists\Components\ViewEntry::make('preview')
                    ->label('Preview Media')
                    ->view('filament.resources.media.preview')
                    ->columnSpanFull(),
                TextEntry::make('nama_media'),
                TextEntry::make('file_path'),
                TextEntry::make('tipe_media')
                    ->badge(),
                TextEntry::make('durasi')
                    ->numeric()
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
