<?php

namespace App\Filament\Resources\KnowledgeAreas\Tables;

use Filament\Tables;
use Filament\Tables\Table;

class KnowledgeAreasTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}