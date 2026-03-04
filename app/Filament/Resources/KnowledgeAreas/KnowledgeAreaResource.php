<?php

namespace App\Filament\Resources\KnowledgeAreas;

use App\Filament\Resources\KnowledgeAreas\Pages\CreateKnowledgeArea;
use App\Filament\Resources\KnowledgeAreas\Pages\EditKnowledgeArea;
use App\Filament\Resources\KnowledgeAreas\Pages\ListKnowledgeAreas;
use App\Filament\Resources\KnowledgeAreas\Schemas\KnowledgeAreaForm;
use App\Filament\Resources\KnowledgeAreas\Tables\KnowledgeAreasTable;
use App\Models\KnowledgeArea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KnowledgeAreaResource extends Resource
{
    protected static ?string $model = KnowledgeArea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Áreas de Conhecimento';

    protected static ?string $modelLabel = 'Área de Conhecimento';

    protected static ?string $pluralModelLabel = 'Áreas de Conhecimento';

    public static function form(Schema $schema): Schema
    {
        return KnowledgeAreaForm::schema($schema);
    }

    public static function table(Table $table): Table
    {
        return KnowledgeAreasTable::table($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKnowledgeAreas::route('/'),
            'create' => CreateKnowledgeArea::route('/create'),
            'edit' => EditKnowledgeArea::route('/{record}/edit'),
        ];
    }
}