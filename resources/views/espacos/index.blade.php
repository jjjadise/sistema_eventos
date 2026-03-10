<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Espaços - Sistema de Eventos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">

<header class="bg-white border-b">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="font-semibold text-lg">Sistema de Eventos</div>
        <nav class="flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Eventos</a>
            <a href="{{ route('espacos.index') }}" class="text-blue-600 font-medium">Espaços</a>
            <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Divulgar Evento
            </a>
        </nav>
    </div>
</header>

<main class="max-w-5xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-900">Espaços da Universidade</h1>
        <p class="text-sm text-gray-500 mt-1">Conheça os espaços disponíveis para eventos</p>
    </div>

    <div class="space-y-12">
        @forelse ($espacos as $espaco)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">

                @if ($espaco->imagem_capa)
                    <div class="w-full h-72 overflow-hidden">
                        <img src="{{ asset('storage/' . $espaco->imagem_capa) }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $espaco->titulo }}</h2>

                    @if (!empty($espaco->conteudo['descricao']))
                        <div class="text-gray-700 mb-6">
                            {!! $espaco->conteudo['descricao'] !!}
                        </div>
                    @endif

                    @if (!empty($espaco->conteudo['capacidade_pessoas']) || !empty($espaco->conteudo['recursos']))
                        <div class="border-t pt-4 mb-4">
                            <h3 class="font-semibold text-gray-800 mb-3">👥 Capacidade e Recursos</h3>
                            @if (!empty($espaco->conteudo['capacidade_pessoas']))
                                <p class="text-gray-700 text-sm mb-2">
                                    Capacidade: <strong>{{ $espaco->conteudo['capacidade_pessoas'] }} pessoas</strong>
                                </p>
                            @endif
                            @if (!empty($espaco->conteudo['area_m2']))
                                <p class="text-gray-700 text-sm mb-2">
                                    Área: <strong>{{ $espaco->conteudo['area_m2'] }} m²</strong>
                                </p>
                            @endif
                            @if (!empty($espaco->conteudo['recursos']))
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($espaco->conteudo['recursos'] as $recurso)
                                        <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">{{ $recurso }}</span>
                                    @endforeach
                                </div>
                            @endif
                            @if (!empty($espaco->conteudo['acessivel']))
                                <p class="text-sm text-green-600 mt-2">♿ Acessível para PCD</p>
                            @endif
                        </div>
                    @endif

                    @if (!empty($espaco->conteudo['endereco']))
                        <div class="border-t pt-4 mb-4">
                            <h3 class="font-semibold text-gray-800 mb-2">📍 Localização</h3>
                            <p class="text-gray-700 text-sm">{{ $espaco->conteudo['endereco'] }}</p>
                            @if (!empty($espaco->conteudo['cidade']))
                                <p class="text-gray-500 text-sm">{{ $espaco->conteudo['cidade'] }}</p>
                            @endif
                            @if (!empty($espaco->conteudo['link_mapa']))
                                <a href="{{ $espaco->conteudo['link_mapa'] }}" target="_blank"
                                   class="inline-block mt-2 text-blue-600 hover:underline text-sm">
                                    Ver no Google Maps →
                                </a>
                            @endif
                        </div>
                    @endif

                    @if (!empty($espaco->conteudo['galeria']))
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-gray-800 mb-3">🖼️ Galeria</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($espaco->conteudo['galeria'] as $foto)
                                    <div class="h-40 rounded-xl overflow-hidden">
                                        <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-16">
                Nenhum espaço cadastrado ainda.
            </div>
        @endforelse
    </div>

</main>

</body>
</html>
