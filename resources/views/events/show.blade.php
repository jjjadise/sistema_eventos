<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-4xl mx-auto px-4 py-10">

    <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">
        ← Voltar
    </a>

    <div class="bg-white rounded-xl shadow-lg mt-4 border overflow-hidden">

        {{-- Banner --}}
        @if ($event->banner)
            <img src="{{ asset('storage/' . $event->banner) }}"
                 class="w-full h-48 object-cover">
        @endif

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="col-span-1">
                <h1 class="text-2xl font-semibold mb-2">{{ $event->title }}</h1>
                <div class="text-sm text-gray-500 mb-4">
                    {{ $event->category->name ?? 'Sem categoria' }}
                </div>
                <div class="text-lg font-bold text-blue-600 mb-2">
                    Data do Evento: {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}
                </div>
                <div class="text-gray-600 mb-2">
                    <strong>Local:</strong> {{ $event->location }}
                </div>
                <div class="text-gray-600 mb-2">
                    <strong>Endereço:</strong> {{ $event->address }}
                </div>
                <div class="text-gray-600 mb-2">
                    <strong>Descrição:</strong> {{ $event->description }}
                </div>
            </div>

            <div class="col-span-1">
                <h2 class="text-lg font-semibold mb-2">Informações Adicionais</h2>
                <div class="text-gray-600 mb-2">
                    <strong>Evento Pago:</strong> {{ $event->is_paid ? 'Sim' : 'Não' }}
                </div>
                <div class="text-gray-600 mb-2">
                    <strong>Possui Intérprete de Libras:</strong> {{ $event->has_interpreter ? 'Sim' : 'Não' }}
                </div>
                <div class="text-gray-600 mb-2">
                    <strong>Espaço Acessível:</strong> {{ $event->is_accessible ? 'Sim' : 'Não' }}
                </div>
                <div class="text-gray-600 mb-2">
                    <strong>Modalidade:</strong> {{ ucfirst($event->modality) }}
                </div>
                <div class="text-gray-600 mb-2">
                    <strong>Link do Evento:</strong> <a href="{{ $event->event_link }}" class="text-blue-600 hover:underline">{{ $event->event_link }}</a>
                </div>
                @if ($event->registration_link)
                    <div class="text-gray-600 mb-2">
                        <strong>Link de Inscrição:</strong> <a href="{{ $event->registration_link }}" class="text-blue-600 hover:underline">{{ $event->registration_link }}</a>
                    </div>
                @endif
            </div>

        </div>

        <div class="mt-6">
            <iframe
                width="100%"
                height="260"
                style="border:0"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps?q={{ urlencode($event->location) }}&output=embed">
            </iframe>
        </div>

    </div>
</div>

</body>
</html>
