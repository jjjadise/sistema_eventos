<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

use Filament\Actions\Action;
use Filament\Actions\EditAction;

use Filament\Forms\Components\Textarea;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('event_date', 'asc')

            ->columns([
                ImageColumn::make('banner')
                    ->label('Banner')
                    ->disk('public')
                    ->square()
                    ->size(60)
                    ->defaultImageUrl(asset('images/banner-placeholder.jpeg')),

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable()
                    ->placeholder('Sem categoria'),

                TextColumn::make('location')
                    ->label('Local')
                    ->searchable(),

                TextColumn::make('event_date')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pendente' => 'warning',
                        'aprovado' => 'success',
                        'rejeitado' => 'danger',
                        default => 'gray',
                    }),
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

            ->actions([
                Action::make('aprovar')
                    ->label('Aprovar')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update([
                        'status' => 'aprovado',
                        'rejection_reason' => null,
                    ]))
                    ->visible(fn ($record) => $record->status === 'pendente'),

                Action::make('rejeitar')
                    ->label('Rejeitar')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Motivo da rejeição')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(fn ($record, array $data) => $record->update([
                        'status' => 'rejeitado',
                        'rejection_reason' => $data['rejection_reason'],
                    ]))
                    ->visible(fn ($record) => $record->status === 'pendente'),

                EditAction::make(),
            ]);
    }
}