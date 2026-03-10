<?php

namespace App\Filament\Resources\Espacos\Pages;

use App\Filament\Resources\EspacoResource;
use App\Models\Espaco;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Str;

class CadastrarEspacos extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = EspacoResource::class;
    protected static ?string $title = 'Cadastrar Espaços em Lote';
    protected string $view = 'filament.resources.espacos.pages.cadastrar-espacos';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('espacos')
                    ->label('Espaços')
                    ->schema([
                        TextInput::make('titulo')
                            ->label('Título')
                            ->nullable(),
                        RichEditor::make('descricao')
                            ->label('Descrição')
                            ->nullable()
                            ->toolbarButtons([
                                'bold', 'italic', 'bulletList', 'orderedList', 'h2', 'h3',
                            ]),
                        FileUpload::make('imagem_capa')
                            ->label('Imagem de Capa')
                            ->image()
                            ->disk('public')
                            ->directory('espacos/capas')
                            ->nullable(),
                        FileUpload::make('galeria')
                            ->label('Galeria de Fotos')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('espacos/galeria')
                        ->nullable()
                            ->nullable(),
                        TextInput::make('endereco')
                            ->label('Endereço')
                            ->nullable(),
                        TextInput::make('capacidade_pessoas')
                            ->label('Capacidade (pessoas)')
                            ->numeric()
                            ->nullable(),
                    ])
                    ->addActionLabel('+ Adicionar outro espaço')
                    ->collapsible()
                    ->cloneable()
                    ->defaultItems(1)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function salvar(): void
    {
        $dados = $this->form->getState();

        foreach ($dados['espacos'] as $espaco) {
            Espaco::create([
                'titulo'      => $espaco['titulo'],
                'slug'        => Str::slug($espaco['titulo']) . '-' . uniqid(),
                'imagem_capa' => $espaco['imagem_capa'] ?? null,
                'conteudo'    => [
                    'descricao'          => $espaco['descricao'] ?? null,
                    'galeria'            => $espaco['galeria'] ?? [],
                    'endereco'           => $espaco['endereco'] ?? null,
                    'capacidade_pessoas' => $espaco['capacidade_pessoas'] ?? null,
                ],
            ]);
        }

        Notification::make()
            ->title('Espaços cadastrados com sucesso!')
            ->success()
            ->send();

        $this->form->fill();
    }
}
