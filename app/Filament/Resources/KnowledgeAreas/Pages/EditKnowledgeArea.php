<?php

namespace App\Filament\Resources\KnowledgeAreas\Pages;

use App\Filament\Resources\KnowledgeAreas\KnowledgeAreaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgeArea extends EditRecord
{
    protected static string $resource = KnowledgeAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
