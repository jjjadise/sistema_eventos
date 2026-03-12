<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Eventos</title>
    @vite('resources/css/app.css')
    <style>
        .scroll-events::-webkit-scrollbar { height: 4px; }
        .scroll-events::-webkit-scrollbar-track { background: #f1f5f9; }
        .scroll-events::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 4px; }
        .card-event:hover .card-img { transform: scale(1.05); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

{{-- Header --}}
<header class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="font-bold text-lg text-blue-600">Eventos Teste</div>
        <nav class="flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-blue-600 font-medium">Eventos</a>
            <a href="{{ route('venues.index') }}" class="text-gray-500 hover:text-gray-900 transition">Espaços</a>
            <a href="{{ route('events.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                + Divulgar Evento
            </a>
        </nav>
    </div>
</header>








@if (session('success'))
<div id="toast-success" class="fixed top-6 right-6 z-50 flex items-start gap-4 bg-white border border-green-200 shadow-xl rounded-2xl px-6 py-4 max-w-sm" style="animation: slideIn 0.4s ease;">
    <div class="flex-shrink-0 bg-green-100 text-green-600 rounded-full w-10 h-10 flex items-center justify-center text-xl">✅</div>
    <div>
        <p class="font-semibold text-gray-900 text-sm">Solicitação recebida!</p>
        <p class="text-gray-500 text-xs mt-0.5">Analisaremos seu evento em breve e você receberá um retorno por e-mail.</p>
    </div>
    <button onclick="document.getElementById('toast-success').remove()" class="text-gray-300 hover:text-gray-500 text-lg ml-2">×</button>
</div>
<style>@keyframes slideIn { from { opacity:0; transform:translateX(60px); } to { opacity:1; transform:translateX(0); } }</style>
<script>
setTimeout(() => {
    const t = document.getElementById('toast-success');
    if (t) { t.style.transition='all 0.5s'; t.style.opacity='0'; t.style.transform='translateX(60px)'; setTimeout(()=>t.remove(),500); }
}, 5000);
</script>
@endif








{{-- Hero --}}
<section class="bg-gradient-to-br from-blue-600 to-blue-400 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-3">Eventos da Universidade</h1>
        <p class="text-blue-100 mb-8 text-lg">Fique por dentro de tudo que está acontecendo</p>
        <form action="{{ route('home') }}" method="GET" class="flex justify-center">
            <div class="flex w-full max-w-md bg-white rounded-xl overflow-hidden shadow-lg">
                <input type="text"
                       name="search"
                       placeholder="Pesquisar eventos..."
                       value="{{ request('search') }}"
                       class="flex-1 px-4 py-3 text-gray-800 text-sm focus:outline-none">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 text-sm font-medium transition">
                    Buscar
                </button>
            </div>
        </form>
    </div>
</section>

<main class="max-w-6xl mx-auto px-4 py-10">

    {{-- Filtro por categoria --}}
    <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2">
        <a href="{{ route('home') }}"
           class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm border transition
                  {{ !request('category') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-200 hover:border-blue-400' }}">
            Todos
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('home', ['category' => $category->id]) }}"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm border transition
                      {{ request('category') == $category->id ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-200 hover:border-blue-400' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    {{-- Eventos --}}
    <div class="mb-2 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Próximos eventos</h2>
            <p class="text-sm text-gray-400 mt-0.5">Role para ver mais →</p>
        </div>
        <a href="{{ route('events.index') }}" class="text-sm text-blue-600 hover:underline font-medium">
            Ver todos →
        </a>
    </div>

    <div class="overflow-x-auto scroll-events pb-4 -mx-4 px-4">
        <div class="flex gap-4" style="width: max-content">
            @forelse ($events as $event)
                <a href="{{ route('events.show', $event) }}"
                   class="card-event bg-white rounded-2xl border shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex-shrink-0 w-64">
                    <div class="h-36 overflow-hidden relative">
                        @if(\Carbon\Carbon::parse($event->event_date)->isPast())
                            <div class="absolute top-2 left-2 z-10 bg-gray-800 bg-opacity-80 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                ⏰ Encerrado
                            </div>
                        @endif
                        @if ($event->banner)
                            <img src="{{ asset('storage/' . $event->banner) }}"
                                 class="card-img w-full h-full object-cover transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-blue-50 flex items-center justify-center text-blue-200 text-3xl">
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
                        <div class="text-xs text-gray-400 mb-2">
                            📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}
                        </div>
                        <div class="text-xs text-gray-500 line-clamp-2">
                            {{ $event->description }}
                        </div>
                        <div class="mt-3 text-xs text-gray-400 truncate">
                            📍 {{ $event->location }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center text-gray-400 py-10 w-full">
                    Nenhum evento aprovado no momento.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-14 bg-white rounded-2xl border shadow-sm p-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Como funciona</span>
            <h2 class="text-xl font-bold text-gray-900 mt-2 mb-4">Divulgue seu evento em 3 passos</h2>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <span class="bg-blue-100 text-blue-600 font-bold text-sm w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0">1</span>
                    <p class="text-gray-600 text-sm">Preencha o formulário com todas as informações do seu evento.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="bg-blue-100 text-blue-600 font-bold text-sm w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0">2</span>
                    <p class="text-gray-600 text-sm">Envie e aguarde a análise da nossa equipe.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="bg-blue-100 text-blue-600 font-bold text-sm w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0">3</span>
                    <p class="text-gray-600 text-sm">Após aprovação, seu evento será publicado na plataforma.</p>
                </div>
            </div>
            <a href="{{ route('events.create') }}"
               class="inline-block mt-6 bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                + Divulgar meu evento
            </a>
        </div>
        <div class="flex items-center justify-center">
            <div class="w-full h-48 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-sm">
                🎥 Vídeo tutorial aqui
            </div>
        </div>
    </div>


    {{-- Banner Espaços --}}
    <div class="mt-14">
        <a href="{{ route('venues.index') }}"
           class="flex items-center justify-between bg-blue-600 hover:bg-blue-700 transition rounded-2xl px-8 py-6 group">
            <div>
                <h2 class="text-lg font-bold text-white">🏛️ Conheça os espaços da Universidade</h2>
                <p class="text-blue-100 text-sm mt-1">Veja os locais disponíveis, capacidade e recursos para o seu evento</p>
            </div>
            <span class="text-white text-2xl group-hover:translate-x-1 transition-transform">→</span>
        </a>
    </div>
</main>

<footer class="mt-16 border-t bg-white py-6 text-center text-sm text-gray-400">
    Sistema de Eventos © {{ date('Y') }}
</footer>

</body>
</html>
