<?php

namespace App\Filament\Resources\Venues\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class VenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->tabs([

                Tab::make('🏠 Geral')->schema([
                    TextInput::make('titulo')
                        ->label('Título')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                       Select::make('conteudo.tipo')
                       ->label('Tipo de Espaço')
                       ->options([
                       'auditorio'          => 'Auditório',
                       'sala_aula'          => 'Sala de Aula',
                       'sala_videoconf'     => 'Sala de Videoconferência',
                       'poliesportivo'      => 'Espaço Poliesportivo',
                       'laboratorio'        => 'Laboratório',
                       'biblioteca'         => 'Biblioteca',
                       'espaco_aberto'      => 'Espaço Aberto',
                       'outro'              => 'Outro',
             ])
             ->required(),
              RichEditor::make('conteudo.descricao')
              ->label('Descrição'),


                ]),

                Tab::make('🖼️ Galeria')->schema([
                    FileUpload::make('imagem_capa')
                        ->label('Imagem de capa')
                        ->image()
                        ->directory('venues/covers'),
                    FileUpload::make('conteudo.galeria')
                        ->label('Galeria de fotos')
                        ->image()
                        ->multiple()
                        ->directory('venues/gallery'),
                ]),

                Tab::make('📍 Localização')->schema([
                    TextInput::make('conteudo.endereco')
                        ->label('Endereço'),
                    TextInput::make('conteudo.cidade')
                        ->label('Cidade'),
                    TextInput::make('conteudo.link_mapa')
                        ->label('Link do mapa')
                        ->url(),
                ]),

                Tab::make('👥 Capacidade e Recursos')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('conteudo.capacidade_pessoas')
                            ->label('Capacidade (pessoas)')
                            ->numeric(),
                        TextInput::make('conteudo.area_m2')
                            ->label('Área (m²)')
                            ->numeric(),
                    ]),
                    TagsInput::make('conteudo.recursos')
                        ->label('Recursos disponíveis')
                        ->suggestions([
                            'Projetor',
                            'Wi-Fi',
                            'Ar-condicionado',
                            'Microfone',
                            'Televisão',
                            'Quadro branco',
                            'Estacionamento',
                            'Acessibilidade',
                            'Cozinha',
                            'Banheiro',
                        ]),
                    Toggle::make('conteudo.acessivel')
                        ->label('Local acessível'),
                ]),

            ])->columnSpanFull(),
        ]);
    }
}
