<?php
namespace App\Filament\Resources\Venues\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class VenuesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('imagem_capa')
                ->label('Capa')
                ->disk('public')
                ->height(50)
                ->width(80)
                ->rounded(),

            TextColumn::make('titulo')
                ->label('Título')
                ->searchable()
                ->sortable(),

            TextColumn::make('conteudo.tipo')
                ->label('Tipo')
                ->badge()
                ->sortable(),

            TextColumn::make('conteudo.capacidade_pessoas')
                ->label('Capacidade')
                ->suffix(' pessoas')
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Criado em')
                ->dateTime('d/m/Y')
                ->sortable(),
        ]);
    }
}