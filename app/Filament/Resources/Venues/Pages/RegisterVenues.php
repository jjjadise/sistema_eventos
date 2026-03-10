<?php

namespace App\Filament\Resources\Venues\Pages;

use App\Filament\Resources\Venues\VenueResource;
use App\Models\Venue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RegisterVenues extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = VenueResource::class;
    protected string $view = 'filament.resources.venues.pages.register-venues';

    public array $dados = [];

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Repeater::make('venues')
                ->label('Espaços')
                ->schema([
                    TextInput::make('titulo')->label('Título')->required(),
                    RichEditor::make('descricao')->label('Descrição'),
                    FileUpload::make('imagem_capa')
                        ->label('Imagem de capa')
                        ->image()
                        ->directory('venues/covers'),
                    FileUpload::make('galeria')
                        ->label('Galeria')
                        ->image()
                        ->multiple()
                        ->directory('venues/gallery'),
                    TextInput::make('endereco')->label('Endereço'),
                    TextInput::make('capacidade_pessoas')->label('Capacidade')->numeric(),
                ])
                ->statePath('dados'),
        ]);
    }

    public function save(): void
    {
        foreach ($this->dados as $venue) {
            Venue::create([
                'titulo'      => $venue['titulo'],
                'slug'        => Str::slug($venue['titulo']) . '-' . uniqid(),
                'imagem_capa' => $venue['imagem_capa'] ?? null,
                'conteudo'    => [
                    'descricao'          => $venue['descricao'] ?? null,
                    'galeria'            => $venue['galeria'] ?? [],
                    'endereco'           => $venue['endereco'] ?? null,
                    'capacidade_pessoas' => $venue['capacidade_pessoas'] ?? null,
                ],
            ]);
        }

        $this->dados = [];
        $this->notify('success', 'Espaços cadastrados com sucesso!');
    }
}
