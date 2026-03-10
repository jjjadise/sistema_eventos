<?php

namespace App\Filament\Resources\Espacos\Pages;

use App\Filament\Resources\EspacoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEspaco extends EditRecord
{
    protected static string $resource = EspacoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
