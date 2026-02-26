<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('aprovar')
                ->label('Aprovar')
                ->color('success')
                ->icon('heroicon-o-check')
                ->requiresConfirmation()
                ->action(function ($record) {

                    $record->update([
                        'status' => 'aprovado',
                        'rejection_reason' => null,
                    ]);

                    Notification::make()
                        ->title('Evento aprovado com sucesso')
                        ->success()
                        ->send();
                })
                ->visible(fn ($record) => $record->status !== 'aprovado'),


            Action::make('rejeitar')
                ->label('Rejeitar')
                ->color('danger')
                ->icon('heroicon-o-x-mark')
                ->form([
                    \Filament\Forms\Components\Textarea::make('rejection_reason')
                        ->label('Motivo da rejeição')
                        ->required()
                        ->rows(3),
                ])
                ->action(function ($record, array $data) {

                    $record->update([
                        'status' => 'rejeitado',
                        'rejection_reason' => $data['rejection_reason'],
                    ]);

                    Notification::make()
                        ->title('Evento rejeitado')
                        ->warning()
                        ->send();
                })
                ->visible(fn ($record) => $record->status !== 'rejeitado'),


            DeleteAction::make()
                ->label('Excluir'),
        ];
    }
}