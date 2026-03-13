<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - Sistema de Eventos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-gray-900">

<header class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="font-bold text-lg text-blue-600">Sistema de Eventos</a>
        <nav class="flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition">Eventos</a>
            <a href="{{ route('venues.index') }}" class="text-gray-500 hover:text-gray-900 transition">Espaços</a>
            <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                + Divulgar Evento
            </a>
        </nav>
    </div>
</header>

<main class="max-w-5xl mx-auto px-4 py-10">

    <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-gray-600 mb-8 inline-flex items-center gap-1 transition">
        ← Voltar para eventos
    </a>

    {{-- Banner --}}
    @if ($event->banner)
    <div class="mt-4 mb-10">
        <img src="{{ asset('storage/' . $event->banner) }}"
             alt="{{ $event->banner_alt_text ?? $event->title }}"
             class="w-full rounded-3xl shadow-lg object-contain max-h-[480px] cursor-zoom-in"
             onclick="document.getElementById('modal-banner').classList.remove('hidden')">
    </div>

    <div id="modal-banner"
         class="hidden fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4"
         onclick="this.classList.add('hidden')">
        <img src="{{ asset('storage/' . $event->banner) }}"
             alt="{{ $event->banner_alt_text ?? $event->title }}"
             class="max-w-full max-h-full rounded-2xl object-contain">
        <p class="absolute bottom-6 text-white text-xs opacity-50">Clique em qualquer lugar para fechar</p>
    </div>
    @endif

    {{-- Layout duas colunas --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

        {{-- Coluna principal --}}
        <div class="lg:col-span-2">

            {{-- Categoria e título --}}
            @if ($event->category)
                <span class="text-xs font-semibold text-blue-600 uppercase tracking-widest">{{ $event->category->name }}</span>
            @endif
            <h1 class="text-4xl font-bold text-gray-900 mt-2 mb-6 leading-tight">{{ $event->title }}</h1>

            {{-- Descrição --}}
            @if ($event->description)
                <p class="text-gray-600 text-lg leading-relaxed mb-10">{{ $event->description }}</p>
            @endif

            {{-- Acessibilidade --}}
            <div class="mb-10">
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Acessibilidade</h2>
                <div class="flex flex-wrap gap-2">
                    <span class="text-sm px-3 py-1.5 rounded-full {{ $event->has_interpreter ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-400 border border-gray-200' }}">
                        {{ $event->has_interpreter ? '✅' : '❌' }} Intérprete de Libras
                    </span>
                    <span class="text-sm px-3 py-1.5 rounded-full {{ $event->is_accessible ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-400 border border-gray-200' }}">
                        {{ $event->is_accessible ? '✅' : '❌' }} Espaço acessível
                    </span>
                </div>
            </div>

            {{-- Mapa --}}
            @if ($event->address && $event->modality !== 'online')
                <div class="mb-10">
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Localização</h2>
                    <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                        <iframe
                            width="100%"
                            height="280"
                            style="border:0"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q={{ urlencode($event->address ?? $event->location) }}&output=embed">
                        </iframe>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">📍 {{ $event->address }}</p>
                </div>
            @endif

            {{-- Compartilhar --}}
            <div class="mb-10">
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Compartilhar</h2>
                <div class="flex flex-wrap gap-2">
                    <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . url()->current()) }}"
                       target="_blank"
                       class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                        📱 WhatsApp
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="flex items-center gap-2 bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                        𝕏 Twitter
                    </a>
                    <button onclick="copyLink()"
                            class="flex items-center gap-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:opacity-90 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                        📸 Instagram
                    </button>
                    <button id="btn-copy" onclick="copyLink()"
                            class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium transition">
                        🔗 Copiar link
                    </button>
                </div>
            </div>

        </div>

        {{-- Coluna lateral --}}
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">

                {{-- Info card --}}
                <div class="bg-gray-50 rounded-2xl p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Data e hora</p>
                        <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y \à\s H:i') }}</p>
                    </div>
                    <div class="border-t border-gray-200"></div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Modalidade</p>
                        <p class="text-gray-800 font-semibold">{{ ucfirst($event->modality) }}</p>
                    </div>
                    <div class="border-t border-gray-200"></div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Local</p>
                        <p class="text-gray-800 font-semibold">{{ $event->location }}</p>
                    </div>
                    <div class="border-t border-gray-200"></div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Ingresso</p>
                        <p class="text-gray-800 font-semibold">{{ $event->is_paid ? 'Evento pago' : 'Entrada gratuita' }}</p>
                    </div>
                </div>

                {{-- CTAs --}}
                <div class="space-y-3">
                    @if ($event->registration_link)
                        <a href="{{ $event->registration_link }}" target="_blank"
                           class="flex items-center justify-center gap-2 w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold text-sm transition">
                            📝 Inscrever-se
                        </a>
                    @endif
                    @if ($event->event_link)
                        <a href="{{ $event->event_link }}" target="_blank"
                           class="flex items-center justify-center gap-2 w-full bg-gray-900 hover:bg-gray-800 text-white px-5 py-3 rounded-xl font-semibold text-sm transition">
                            🔗 Acessar evento
                        </a>
                    @endif
                    <a href="{{ route('events.ics', $event) }}"
                       class="flex items-center justify-center gap-2 w-full bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-5 py-3 rounded-xl font-medium text-sm transition">
                        📅 Adicionar à agenda
                    </a>
                </div>

            </div>
        </div>

    </div>

</main>

<footer class="mt-16 border-t py-6 text-center text-sm text-gray-400">
    Sistema de Eventos © {{ date('Y') }}
</footer>

<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const btn = document.getElementById('btn-copy');
        btn.innerText = '✅ Link copiado!';
        setTimeout(() => btn.innerText = '🔗 Copiar link', 2000);
    });
}
</script>

</body>
</html>