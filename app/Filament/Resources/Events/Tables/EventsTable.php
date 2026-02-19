<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Local')
                    ->searchable(),

                TextColumn::make('event_date')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pendente',
                        'success' => 'aprovado',
                        'danger' => 'rejeitado',
                    ]),
            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pendente' => 'Pendente',
                        'aprovado' => 'Aprovado',
                        'rejeitado' => 'Rejeitado',
                    ]),

                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Categoria'),
            ])

            ->recordActions([

                Tables\Actions\Action::make('aprovar')
                    ->label('Aprovar')
                    ->color('success')
                    ->action(fn ($record) => $record->update([
                        'status' => 'aprovado',
                        'rejection_reason' => null,
                    ]))
                    ->visible(fn ($record) => $record->status !== 'aprovado'),

                Tables\Actions\Action::make('rejeitar')
                    ->label('Rejeitar')
                    ->color('danger')
                    ->action(fn ($record) => $record->update([
                        'status' => 'rejeitado',
                    ]))
                    ->visible(fn ($record) => $record->status !== 'rejeitado'),

                EditAction::make(),
            ]);
    }
}
