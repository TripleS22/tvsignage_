<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),
                TextInput::make('nama_media')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\FileUpload::make('file_path')
                    ->label('File Media')
                    ->disk('public')
                    ->directory('media')
                    ->required()
                    ->acceptedFileTypes(['video/mp4', 'image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(51200) // 50MB
                    ->preserveFilenames(),
                Select::make('tipe_media')
                    ->options([
                        'video' => 'Video',
                        'gambar' => 'Gambar',
                    ])
                    ->default('gambar')
                    ->required()
                    ->live(),
                TextInput::make('durasi')
                    ->label('Durasi (Detik)')
                    ->helperText('Kosongkan jika ingin menggunakan durasi default gabungan')
                    ->numeric()
                    ->visible(fn (callable $get) => $get('tipe_media') === 'video'),
            ]);
    }
}
