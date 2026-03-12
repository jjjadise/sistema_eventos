<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - Sistema de Eventos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">

<header class="bg-white border-b">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="font-semibold text-lg">Sistema de Eventos</div>
        <nav class="flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Eventos</a>
            <a href="{{ route('venues.index') }}" class="text-gray-600 hover:text-black">Espaços</a>
            <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Divulgar Evento
            </a>
        </nav>
    </div>
</header>

<main class="max-w-4xl mx-auto px-4 py-10">

    <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline mb-6 inline-block">
        ← Voltar para eventos
    </a>

    {{-- Banner --}}
    @if ($event->banner)
        <div class="w-full h-72 rounded-2xl overflow-hidden shadow mb-8">
            <img src="{{ asset('storage/' . $event->banner) }}"
                 alt="{{ $event->banner_alt_text ?? $event->title }}"
                 class="w-full h-full object-cover">
        </div>
    @endif

    {{-- Título e categoria --}}
    <div class="mb-6">
        @if ($event->category)
            <span class="bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">
                {{ $event->category->name }}
            </span>
        @endif
        <h1 class="text-3xl font-bold text-gray-900 mt-3">{{ $event->title }}</h1>
    </div>

    {{-- Informações principais --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-xl border shadow-sm p-4">
            <p class="text-xs text-gray-400 uppercase mb-1">Data e hora</p>
            <p class="text-gray-800 font-medium">
                📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y \à\s H:i') }}
            </p>
        </div>
        <div class="bg-white rounded-xl border shadow-sm p-4">
            <p class="text-xs text-gray-400 uppercase mb-1">Modalidade</p>
            <p class="text-gray-800 font-medium">
                🎓 {{ ucfirst($event->modality) }}
            </p>
        </div>
        <div class="bg-white rounded-xl border shadow-sm p-4">
            <p class="text-xs text-gray-400 uppercase mb-1">Local</p>
            <p class="text-gray-800 font-medium">📍 {{ $event->location }}</p>
            @if ($event->address)
                <p class="text-gray-500 text-sm mt-1">{{ $event->address }}</p>
            @endif
        </div>
        <div class="bg-white rounded-xl border shadow-sm p-4">
            <p class="text-xs text-gray-400 uppercase mb-1">Ingresso</p>
            <p class="text-gray-800 font-medium">
                {{ $event->is_paid ? '💰 Evento pago' : '🎟️ Entrada gratuita' }}
            </p>
        </div>
    </div>

    {{-- Descrição --}}
    @if ($event->description)
        <div class="bg-white rounded-2xl border shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Sobre o evento</h2>
            <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
        </div>
    @endif

    {{-- Acessibilidade e recursos --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Acessibilidade</h2>
        <div class="flex flex-wrap gap-3">
            <span class="text-sm px-3 py-1 rounded-full {{ $event->has_interpreter ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                {{ $event->has_interpreter ? '✅' : '❌' }} Intérprete de Libras
            </span>
            <span class="text-sm px-3 py-1 rounded-full {{ $event->is_accessible ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                {{ $event->is_accessible ? '✅' : '❌' }} Espaço acessível
            </span>
        </div>
    </div>

    {{-- Links --}}
    <div class="flex flex-wrap gap-3 mb-8">
        @if ($event->event_link)
            <a href="{{ $event->event_link }}" target="_blank"
               class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                🔗 Acessar evento
            </a>
        @endif
        @if ($event->registration_link)
            <a href="{{ $event->registration_link }}" target="_blank"
               class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                📝 Inscrever-se
            </a>
        @endif
    </div>


    {{-- Adicionar à agenda --}}
    <div class="mb-8">
        <a href="{{ route('events.ics', $event) }}"
           class="inline-flex items-center gap-2 bg-gray-800 text-white px-5 py-2 rounded-lg hover:bg-gray-900 transition text-sm font-medium">
            📅 Adicionar à agenda (.ics)
        </a>
    </div>

    {{-- Mapa --}}
    @if ($event->location)
        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden mb-6">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">📍 Localização</h2>
            </div>
            <iframe
                width="100%"
                height="300"
                style="border:0"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps?q={{ urlencode($event->address ?? $event->location) }}&output=embed">
            </iframe>
        </div>
    @endif



</main>

</body>
</html>
