<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Espacos\Pages\CreateEspaco;
use App\Filament\Resources\Espacos\Pages\EditEspaco;
use App\Filament\Resources\Espacos\Pages\CadastrarEspacos;
use App\Filament\Resources\Espacos\Pages\ListEspacos;
use App\Models\Espaco;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class EspacoResource extends Resource
{
    protected static ?string $model = Espaco::class;
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;
    protected static ?string $navigationLabel = 'Espaços';
    protected static string|\UnitEnum|null $navigationGroup = 'Gerenciamento';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Espaço';
    protected static ?string $pluralModelLabel = 'Espaços';
    protected static ?string $recordTitleAttribute = 'titulo';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Espaço')
                ->tabs([
                    Tab::make('🏠 Geral')
                        ->schema([
                            TextInput::make('titulo')
                                ->label('Título do Espaço')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) =>
                                    $set('slug', Str::slug($state))
                                ),
                            TextInput::make('slug')
                                ->label('Slug (URL)')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->prefix('/espacos/'),
                            FileUpload::make('imagem_capa')
                                ->label('Imagem de Capa')
                                ->image()
                                ->disk('public')
                                ->directory('espacos/capas')
                                ->nullable(),
                            RichEditor::make('conteudo.descricao')
                                ->label('Descrição do Espaço')
                                ->required()
                                ->toolbarButtons([
                                    'bold', 'italic', 'underline',
                                    'bulletList', 'orderedList',
                                    'h2', 'h3', 'link',
                                ]),
                        ]),

                    Tab::make('🖼️ Galeria')
                        ->schema([
                            FileUpload::make('conteudo.galeria')
                                ->label('Fotos do Espaço')
                                ->multiple()
                                ->image()
                                ->disk('public')
                                ->directory('espacos/galeria')
                                ->reorderable()
                                ->required(),
                        ]),

                    Tab::make('📍 Localização')
                        ->schema([
                            TextInput::make('conteudo.endereco')
                                ->label('Endereço')
                                ->required(),
                            Grid::make(2)->schema([
                                TextInput::make('conteudo.cidade')
                                    ->label('Cidade')
                                    ->required(),
                                TextInput::make('conteudo.cep')
                                    ->label('CEP')
                                    ->mask('99999-999')
                                    ->nullable(),
                            ]),
                            TextInput::make('conteudo.link_mapa')
                                ->label('Link do Google Maps')
                                ->url()
                                ->nullable()
                                ->prefix('https://'),
                        ]),

                    Tab::make('👥 Capacidade e Recursos')
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('conteudo.capacidade_pessoas')
                                    ->label('Capacidade (pessoas)')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('conteudo.area_m2')
                                    ->label('Área (m²)')
                                    ->numeric()
                                    ->nullable(),
                            ]),
                            TagsInput::make('conteudo.recursos')
                                ->label('Recursos disponíveis')
                                ->placeholder('Ex: Projetor, Wi-Fi...')
                                ->suggestions([
                                    'Projetor',
                                    'Wi-Fi',
                                    'Ar condicionado',
                                    'Estacionamento',
                                    'Acessibilidade',
                                    'Cozinha',
                                    'Som ambiente',
                                    'Lousa',
                                ]),
                            Toggle::make('conteudo.acessivel')
                                ->label('Acessível para PCD')
                                ->default(false),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagem_capa')->disk('public')->label('Capa'),
                TextColumn::make('titulo')->sortable()->searchable()->label('Título'),
                TextColumn::make('slug')->label('Slug')->color('gray'),
                TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y')->sortable(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('created_at');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEspacos::route('/'),
            'create' => CreateEspaco::route('/create'),
            'edit' => EditEspaco::route('/{record}/edit'),
            'cadastrar' => CadastrarEspacos::route('/cadastrar'),
        ];
    }
}
