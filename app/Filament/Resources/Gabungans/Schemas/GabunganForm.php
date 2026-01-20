<?php

namespace App\Filament\Resources\Gabungans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GabunganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(auth()->id()),
                TextInput::make('nama_gabungan')
                    ->required()
                    ->maxLength(255),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                TextInput::make('jeda_detik')
                    ->label('Jeda Antar Media (Detik)')
                    ->required()
                    ->numeric()
                    ->default(5)
                    ->minValue(1),
                
                Section::make('Daftar Media (Urutkan)')
                    ->description('Pilih media dan atur urutannya. Seret card untuk merubah urutan.')
                    ->schema([
                        Repeater::make('gabunganMedia')
                            ->relationship()
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(3)
                                    ->schema([
                                        \Filament\Forms\Components\ViewField::make('media_preview')
                                            ->view('filament.resources.media.preview-item')
                                            ->columnSpan(1)
                                            ->dehydrated(false),
                                        
                                        Select::make('media_id')
                                            ->relationship('media', 'nama_media')
                                            ->required()
                                            ->preload()
                                            ->label('Pilih Media')
                                            ->live()
                                            ->columnSpan(2),
                                    ]),
                            ])
                            ->orderColumn('urutan')
                            ->reorderableWithDragAndDrop()
                            ->itemLabel(fn ($state) => \App\Models\Media::find($state['media_id'] ?? null)?->nama_media ?? 'Pilih Media')
                            ->collapsible()
                            ->collapsed(false)
                            ->addActionLabel('Tambah Media ke Gabungan'),
                    ]),

            ]);
    }
}
