<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $event->title }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">

<div class="max-w-4xl mx-auto px-4 py-10">

    <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline">
        ← Voltar
    </a>

    <div class="bg-white rounded-xl shadow-sm mt-4 border overflow-hidden">

        {{-- Banner --}}
        @if ($event->banner)
            <img src="{{ asset('storage/' . $event->banner) }}"
                 class="w-full h-64 object-cover">
        @endif

        <div class="p-8">

            <div class="text-sm text-blue-600 mb-2">
                {{ $event->category->name ?? 'Sem categoria' }}
            </div>

            <h1 class="text-3xl font-semibold mb-4">
                {{ $event->title }}
            </h1>

            <div class="text-gray-600 mb-6 space-y-1">
                <div>📍 {{ $event->location }}</div>
                <div>🗓 {{ $event->event_date->format('d/m/Y H:i') }}</div>
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


            <div class="text-gray-800 leading-relaxed">
                {{ $event->description }}
            </div>

        </div>

    </div>
</div>

</body>
</html>