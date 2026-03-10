<?php


namespace App\Filament\Resources\Espacos; // Apenas esta linha deve existir

use App\Filament\Resources\Espacos\Pages\CreateEspaco;
use App\Filament\Resources\Espacos\Pages\EditEspaco;
use App\Filament\Resources\Espacos\Pages\ListEspacos;
use App\Filament\Resources\Espacos\Schemas\EspacoForm;
use App\Models\Espaco;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EspacoResource extends Resource

{
    protected static ?string $model = Espaco::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Espaços';

    protected static string|\UnitEnum|null $navigationGroup = 'Gerenciamento';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Espaço';

    protected static ?string $pluralModelLabel = 'Espaços';

    protected static ?string $recordTitleAttribute = 'titulo'; // Atributo que representa o título

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            // Defina os campos do formulário
            Forms\Components\TextInput::make('titulo')
                ->required()
                ->label('Título'),
            Forms\Components\Textarea::make('descricao')
                ->required()
                ->label('Descrição'),
            Forms\Components\FileUpload::make('imagem')
                ->label('Imagem')
                ->disk('public')
                ->directory('espacos')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('descricao')->limit(50),
                Tables\Columns\ImageColumn::make('imagem')->disk('public')->label('Imagem'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest('created_at');
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
        ];
    }
}
