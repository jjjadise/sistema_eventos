<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Eventos - Sistema de Eventos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">

<header class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="font-bold text-lg text-blue-600">Sistema de Eventos</a>
        <nav class="flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition">Início</a>
            <a href="{{ route('events.index') }}" class="text-blue-600 font-medium">Eventos</a>
            <a href="{{ route('venues.index') }}" class="text-gray-500 hover:text-gray-900 transition">Espaços</a>
            <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">
                + Divulgar Evento
            </a>
        </nav>
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Todos os eventos</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $events->total() }} evento(s) encontrado(s)</p>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('events.index') }}" class="bg-white rounded-2xl border shadow-sm p-4 mb-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nome do evento..."
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Categoria</label>
                <select name="category" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Modalidade</label>
                <select name="modality" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas</option>
                    <option value="presencial" {{ request('modality') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                    <option value="online" {{ request('modality') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="hibrido" {{ request('modality') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Campus</label>
                <select name="campus" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach ($campuses as $campus)
                        <option value="{{ $campus->id }}" {{ request('campus') == $campus->id ? 'selected' : '' }}>
                            {{ $campus->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex items-center gap-3 mt-4">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-600 mb-1">Data</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex gap-2 mt-5">
                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    Filtrar
                </button>
                <a href="{{ route('events.index') }}"
                   class="bg-gray-100 text-gray-600 px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Limpar
                </a>
            </div>
        </div>
    </form>

    {{-- Grid de eventos --}}
    @forelse ($events as $event)
        @if ($loop->first)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @endif

        <a href="{{ route('events.show', $event) }}"
           class="bg-white rounded-2xl border shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
            <div class="h-40 overflow-hidden relative">
                @if (\Carbon\Carbon::parse($event->event_date)->isPast())
                    <div class="absolute top-2 left-2 z-10 bg-gray-800 bg-opacity-80 text-white text-xs font-semibold px-2 py-1 rounded-full">
                        ⏰ Encerrado
                    </div>
                @endif
                @if ($event->banner)
                    <img src="{{ asset('storage/' . $event->banner) }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-blue-50 flex items-center justify-center text-blue-200 text-4xl">
                        📅
                    </div>
                @endif
            </div>
            <div class="p-4">
                @if ($event->category)
                    <span class="text-xs text-blue-600 font-medium">{{ $event->category->name }}</span>
                @endif
                <div class="font-semibold text-gray-900 mt-1 mb-1 line-clamp-2 text-sm leading-snug">
                    {{ $event->title }}
                </div>
                <div class="text-xs text-gray-400 mb-1">
                    📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}
                </div>
                <div class="text-xs text-gray-400 mb-2">
                    @if ($event->modality === 'presencial') 🏛️ Presencial
                    @elseif ($event->modality === 'online') 💻 Online
                    @else 🔀 Híbrido
                    @endif
                    @if ($event->campus)
                        · {{ $event->campus->name }}
                    @endif
                </div>
                <div class="mt-2">
                    @if ($event->is_paid)
                        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">Pago</span>
                    @else
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Gratuito</span>
                    @endif
                </div>
            </div>
        </a>

        @if ($loop->last)
            </div>
        @endif
    @empty
        <div class="text-center py-20 text-gray-400">
            <div class="text-5xl mb-4">🔍</div>
            <p class="text-lg font-medium">Nenhum evento encontrado</p>
            <p class="text-sm mt-1">Tente ajustar os filtros</p>
        </div>
    @endforelse

    {{-- Paginação --}}
    @if ($events->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $events->links() }}
        </div>
    @endif

</main>

<footer class="mt-16 border-t bg-white py-6 text-center text-sm text-gray-400">
    Sistema de Eventos © {{ date('Y') }}
</footer>

</body>
</html>
