<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                FileUpload::make('banner')
                    ->label('Banner do Evento')
                    ->image()
                    ->disk('public')
                    ->directory('banners')
                    ->imageEditor() // permite cortar / ajustar
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('left')
                    ->panelAspectRatio('2:1')
                    ->panelLayout('integrated')
                    ->maxSize(2048)
                    ->helperText('PNG ou JPG • Máx 2MB')
                    ->columnSpanFull(),

                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Selecione uma categoria')
                    ->required(),

                TextInput::make('title')
                    ->label('Título')
                    ->placeholder('Ex: Workshop de Tecnologia')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Descrição')
                    ->placeholder('Descreva os detalhes do evento...')
                    ->rows(5)
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('location')
                    ->label('Local')
                    ->placeholder('Ex: Fortaleza - CE')
                    ->required(),


                TextInput::make('address')
                 ->label('Endereço completo')
                 ->placeholder('Av. da Universidade, 2853 - Benfica, Fortaleza - CE')
                 ->helperText('Este endereço será usado para exibir o mapa')
                 ->maxLength(255),


                DateTimePicker::make('event_date')
                    ->label('Data do Evento')
                    ->seconds(false)
                    ->native(false) // UI mais bonita no Filament
                    ->displayFormat('d/m/Y H:i')
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
                    ->placeholder('Explique por que o evento foi rejeitado...')
                    ->rows(4)
                    ->required(fn ($get) => $get('status') === 'rejeitado')
                    ->visible(fn ($get) => $get('status') === 'rejeitado')
                    ->columnSpanFull(),
            ]);
    }
}