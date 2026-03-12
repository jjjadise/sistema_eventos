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
                    ->imageEditor()
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

                
                

                

                    Select::make('campus_id')
                    ->label('Campus')
                    ->relationship('campus', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                    Select::make('knowledge_area_id')
                    ->label('Área de Conhecimento')
                    ->relationship('knowledgeArea', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                    TextInput::make('event_link')
                    ->label('Link do Evento')
                    ->url()
                    ->required(),
                    TextInput::make('registration_link')
                    ->label('Link de Inscrição')
                    ->url(),
                    Select::make('is_paid')
                    ->label('Evento Pago?')
                    ->options([
                      1 => 'Sim',
                      0 => 'Não',
                  ])
                    ->required(),
                    Select::make('has_interpreter')
                   ->label('Possui Intérprete de Libras?')
                   ->options([
                   1 => 'Sim',
                   0 => 'Não',
               ])
                   ->required(),
                    Select::make('is_accessible')
                   ->label('Espaço Acessível?')
                   ->options([
                   1 => 'Sim',
                   0 => 'Não',
             ])
                    ->required(),
                    TextInput::make('banner_alt_text')
                    ->label('Texto Alternativo do Banner')
                    ->required(),
                    TextInput::make('responsible_name')
                    ->label('Nome do Responsável')
                    ->required(),
                    TextInput::make('responsible_phone')
                    ->label('Telefone do Responsável')
                    ->required(),
                    TextInput::make('responsible_email')
                    ->label('Email do Responsável')
                    ->email()
                    ->required(),


                    Select::make('modality')
                    ->label('Modalidade')
                    ->options([
                    'presencial' => 'Presencial',
                    'online' => 'Online',
                    'hibrido' => 'Híbrido',
                     ])
                    ->required(),





                DateTimePicker::make('event_date')
                    ->label('Data do Evento')
                    ->seconds(false)
                    ->native(false)
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