<?php

namespace App\Filament\Resources\KnowledgeAreas\Pages;

use App\Filament\Resources\KnowledgeAreas\KnowledgeAreaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKnowledgeAreas extends ListRecords
{
    protected static string $resource = KnowledgeAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
