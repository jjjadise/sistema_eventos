<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Category;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Descrição')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('location')
                    ->label('Local')
                    ->required(),

                DateTimePicker::make('event_date')
                    ->label('Data do Evento')
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pendente' => 'Pendente',
                        'aprovado' => 'Aprovado',
                        'rejeitado' => 'Rejeitado',
                    ])
                    ->disabled()
                    ->dehydrated()
                    ->default('pendente'),

                Textarea::make('rejection_reason')
                    ->label('Motivo da Rejeição')
                    ->visible(fn ($get) => $get('status') === 'rejeitado')
                    ->columnSpanFull(),
            ]);
    }
}
