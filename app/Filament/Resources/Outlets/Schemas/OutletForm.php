<?php

namespace App\Filament\Resources\Outlets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OutletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),
                TextInput::make('kode_outlet')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('nama_outlet')
                    ->required()
                    ->maxLength(255),
                Select::make('gabungan_id')
                    ->label('Composition (Gabungan Media)')
                    ->relationship('gabungan', 'nama_gabungan')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Pilih gabungan media yang akan ditampilkan di outlet ini'),
                Select::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'tidak_aktif' => 'Tidak Aktif',
                        'dijadwalkan' => 'Dijadwalkan',
                    ])
                    ->default('tidak_aktif')
                    ->required()
                    ->live(),
                \Filament\Schemas\Components\Grid::make(2)
                    ->schema([
                        DateTimePicker::make('jadwal_mulai')
                            ->visible(fn (callable $get) => $get('status') === 'dijadwalkan')
                            ->required(fn (callable $get) => $get('status') === 'dijadwalkan'),
                        DateTimePicker::make('jadwal_selesai')
                            ->visible(fn (callable $get) => $get('status') === 'dijadwalkan')
                            ->required(fn (callable $get) => $get('status') === 'dijadwalkan'),
                    ]),
            ]);
    }
}
