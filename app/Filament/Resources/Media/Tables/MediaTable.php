<?php

namespace App\Filament\Resources\Media\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ViewColumn::make('file_path')
                    ->label('Preview thumb')
                    ->view('filament.tables.columns.media-preview')
                    ->action(
                        \Filament\Actions\Action::make('preview')
                            ->modalContent(fn ($record) => view('filament.resources.media.preview', ['record' => $record]))
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                    ),
                TextColumn::make('nama_media')
                    ->searchable(),
                TextColumn::make('tipe_media')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'video' => 'warning',
                        'gambar' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('durasi')
                    ->label('Durasi')
                    ->suffix(' detik')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
