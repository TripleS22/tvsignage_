<?php

namespace App\Filament\Resources\Publishes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class PublishInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Group::make([
                            Section::make('Koneksi & Status')
                                ->description('Informasi koneksi realtime dari signage player.')
                                ->schema([
                                    IconEntry::make('is_online')
                                        ->label('Status Online')
                                        ->boolean()
                                        ->trueIcon('heroicon-o-check-circle')
                                        ->falseIcon('heroicon-o-x-circle')
                                        ->color(fn ($state) => $state ? 'success' : 'danger'),
                                    TextEntry::make('last_ping')
                                        ->label('Kontak Terakhir')
                                        ->dateTime()
                                        ->since()
                                        ->badge()
                                        ->color('gray')
                                        ->placeholder('-'),
                                    TextEntry::make('status')
                                        ->label('Status Publish')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'published' => 'success',
                                            'draft' => 'gray',
                                            'stopped' => 'danger',
                                            default => 'gray',
                                        }),
                                ])->columns(1),
                        ]),

                        Group::make([
                            Section::make('Informasi Outlet')
                                ->description('Detail lokasi dan grup media yang ditugaskan.')
                                ->schema([
                                    TextEntry::make('outlet.nama_outlet')
                                        ->label('Nama Outlet')
                                        ->weight('bold'),
                                    TextEntry::make('gabungan.nama_gabungan')
                                        ->label('Komposisi Media'),
                                    TextEntry::make('published_at')
                                        ->label('Waktu Publish')
                                        ->dateTime()
                                        ->placeholder('-'),
                                ])->columns(1),
                        ]),
                    ]),

                Section::make('Snapshot Konten Realtime')
                    ->description('Daftar media dan jadwal yang saat ini aktif di layar TV.')
                    ->schema([
                        TextEntry::make('notes')
                            ->label('')
                            ->formatStateUsing(fn ($state) => nl2br($state))
                            ->html()
                            ->prose()
                            ->placeholder('Menunggu data dari player...')
                            ->extraAttributes([
                                'class' => 'font-mono text-sm bg-gray-50 p-4 rounded-xl border border-gray-200'
                            ]),
                    ]),
                
                Section::make('Metadata')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->label('Diperbarui Pada')
                                    ->dateTime(),
                            ]),
                    ])->collapsed(),
            ]);
    }
}
