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
            <a href="{{ route('venues.index') }}" class="text-blue-600 font-medium">Espaços</a>
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

    <form method="GET" action="{{ route('venues.index') }}" class="bg-white rounded-2xl border shadow-sm p-4 mb-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nome do espaço..."
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Capacidade mínima</label>
                <input type="number" name="capacidade" value="{{ request('capacidade') }}"
                       placeholder="Ex: 50"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Recurso</label>
                <select name="recurso" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach ($recursos as $r)
                        <option value="{{ $r }}" {{ request('recurso') == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col justify-end">
                <label class="flex items-center gap-2 text-sm text-gray-700 mb-2">
                    <input type="checkbox" name="acessivel" value="1" {{ request('acessivel') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600">
                    ♿ Apenas acessíveis
                </label>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                        Filtrar
                    </button>
                    <a href="{{ route('venues.index') }}" class="flex-1 text-center bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                        Limpar
                    </a>
                </div>
            </div>
        </div>
    </form>

    <div class="space-y-12">
        @forelse ($venues as $venue)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">

                @if ($venue->imagem_capa)
                    <div class="w-full h-72 overflow-hidden">
                        <img src="{{ asset('storage/' . $venue->imagem_capa) }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $venue->titulo }}</h2>

                    @if (!empty($venue->conteudo['descricao']))
                        <div class="text-gray-700 mb-6">
                            {!! $venue->conteudo['descricao'] !!}
                        </div>
                    @endif

                    @if (!empty($venue->conteudo['capacidade_pessoas']) || !empty($venue->conteudo['recursos']))
                        <div class="border-t pt-4 mb-4">
                            <h3 class="font-semibold text-gray-800 mb-3">👥 Capacidade e Recursos</h3>
                            @if (!empty($venue->conteudo['capacidade_pessoas']))
                                <p class="text-gray-700 text-sm mb-2">
                                    Capacidade: <strong>{{ $venue->conteudo['capacidade_pessoas'] }} pessoas</strong>
                                </p>
                            @endif
                            @if (!empty($venue->conteudo['area_m2']))
                                <p class="text-gray-700 text-sm mb-2">
                                    Área: <strong>{{ $venue->conteudo['area_m2'] }} m²</strong>
                                </p>
                            @endif
                            @if (!empty($venue->conteudo['recursos']))
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($venue->conteudo['recursos'] as $recurso)
                                        <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">{{ $recurso }}</span>
                                    @endforeach
                                </div>
                            @endif
                            @if (!empty($venue->conteudo['acessivel']))
                                <p class="text-sm text-green-600 mt-2">♿ Acessível para PCD</p>
                            @endif
                        </div>
                    @endif

                    @if (!empty($venue->conteudo['endereco']))
                        <div class="border-t pt-4 mb-4">
                            <h3 class="font-semibold text-gray-800 mb-2">📍 Localização</h3>
                            <p class="text-gray-700 text-sm">{{ $venue->conteudo['endereco'] }}</p>
                            @if (!empty($venue->conteudo['cidade']))
                                <p class="text-gray-500 text-sm">{{ $venue->conteudo['cidade'] }}</p>
                            @endif
                            @if (!empty($venue->conteudo['link_mapa']))
                                <a href="{{ $venue->conteudo['link_mapa'] }}" target="_blank"
                                   class="inline-block mt-2 text-blue-600 hover:underline text-sm">
                                    Ver no Google Maps →
                                </a>
                            @endif
                        </div>
                    @endif

                    @if (!empty($venue->conteudo['galeria']))
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-gray-800 mb-3">🖼️ Galeria</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($venue->conteudo['galeria'] as $foto)
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
