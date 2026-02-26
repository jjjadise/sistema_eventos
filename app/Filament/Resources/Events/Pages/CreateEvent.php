<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Garante vínculo com usuário logado
        $data['user_id'] = auth()->id();

        // BLINDAGEM DE STATUS (regra de negócio)
        $data['status'] = 'pendente';

        return $data;
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Evento criado como pendente')
            ->success()
            ->send();
    }
}