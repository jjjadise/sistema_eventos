<?php

namespace App\Filament\Resources\KnowledgeAreas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KnowledgeAreaForm
{
    public static function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome da Área')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}