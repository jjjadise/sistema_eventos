<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Eventos</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-900">

<header class="bg-white border-b">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">

        <div class="font-semibold text-lg">
            Sistema de Eventos
        </div>

        <nav class="flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-black">
                Eventos
            </a>

            <a href="{{ route('events.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Divulgar Evento
            </a>
        </nav>

    </div>
</header>

<main class="max-w-6xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-2xl font-semibold">
            Eventos disponíveis
        </h1>
        <p class="text-sm text-gray-500">
            Encontre eventos aprovados para divulgação
        </p>
    </div>

    <div class="mb-8">
        <input type="text"
               placeholder="Pesquisar eventos..."
               class="w-full bg-white border rounded-xl px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse ($events as $event)

            <a href="{{ route('events.show', $event) }}"
               class="bg-white rounded-xl border shadow-sm hover:shadow-md transition overflow-hidden block">

                {{-- Banner --}}
                @if ($event->banner)
                    <img src="{{ asset('storage/' . $event->banner) }}"
                         class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                        Sem banner
                    </div>
                @endif

                <div class="p-5">

                    <div class="text-sm text-gray-500 mb-1">
                        {{ optional($event->event_date)->format('d/m/Y H:i') }}
                    </div>

                    <div class="font-medium mb-2">
                        {{ $event->title }}
                    </div>

                    <div class="text-sm text-gray-600 line-clamp-2">
                        {{ $event->description }}
                    </div>

                    <div class="mt-3 text-xs text-gray-500">
                        {{ $event->location }}
                    </div>

                </div>

            </a>

        @empty
            <div class="col-span-full text-center text-gray-500 py-10">
                Nenhum evento aprovado no momento.
            </div>
        @endforelse

    </div>

</main>

</body>
</html>