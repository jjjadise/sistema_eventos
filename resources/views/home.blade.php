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

@if (session('success'))
    <div class="bg-green-600 text-white px-4 py-3 rounded-lg mb-4">
        ✅ Recebemos sua solicitação! Você receberá um retorno em breve.
    </div>
@endif

<main class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold">
            Próximos eventos
        </h1>
        <p class="text-sm text-gray-500">
            eventos próximos
        </p>
    </div>

    <div class="mb-8">
        <form action="{{ route('home') }}" method="GET"> <!-- Ajuste a rota conforme necessário -->
            <input type="text"
                   name="search"
                   placeholder="Pesquisar eventos..."
                   value="{{ request('search') }}" 
                   class="w-full bg-white border rounded-xl px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        </form>
    </div>

    <!-- Container para rolagem lateral -->
    <div class="overflow-x-auto">
        <div class="flex space-x-4 pb-4"> <!-- Usando flexbox para permitir rolagem horizontal -->
            @forelse ($events as $event)
                <a href="{{ route('events.show', $event) }}"
                   class="bg-white rounded-lg border shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden w-64 flex-shrink-0"> <!-- Largura ajustada -->
                    {{-- Banner --}}
                    <div class="h-32 overflow-hidden"> <!-- Define a altura do banner -->
                        @if ($event->banner)
                            <img src="{{ asset('storage/' . $event->banner) }}"
                                 class="w-full h-full object-cover"> <!-- Ajuste para cobrir o espaço -->
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                                Sem banner
                            </div>
                        @endif
                    </div>

                    <div class="p-4"> <!-- Ajuste no padding -->
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
    </div>

    <!-- Seção Sobre e Tutorial de Solicitação de Divulgação -->
    <div class="mt-10 bg-white rounded-xl shadow-md p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h2 class="text-xl font-semibold mb-4">Sobre e Tutorial de Solicitação de Divulgação</h2>
            <p class="text-gray-700 mb-2">
                Aqui você encontrará informações sobre como solicitar a divulgação de seus eventos. 
                Siga as etapas abaixo:
            </p>
            <ul class="list-disc list-inside text-gray-600">
                <li>Preencha o formulário de divulgação com todas as informações necessárias.</li>
                <li>Envie o formulário e aguarde a confirmação.</li>
                <li>Após a aprovação, seu evento será divulgado em nossa plataforma.</li>
            </ul>
        </div>
        <div class="flex items-center justify-center">
            <div class="w-48 h-32 bg-gray-200 flex items-center justify-center text-gray-500 text-xl">
                Vídeo Aqui
            </div>
        </div>
    </div>

    <!-- Seção Conheça os Espaços da Universidade -->
    <div class="mt-10 bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Conheça os Espaços da Universidade</h2>
        <p class="text-gray-700 mb-2">
            A universidade oferece diversos espaços que podem ser utilizados para eventos. 
            Alguns dos principais locais incluem:
        </p>
        <ul class="list-disc list-inside text-gray-600">
            <li>Auditório Principal</li>
            <li>Salas de Aula</li>
            <li>Espaço ao Ar Livre</li>
            <li>Centro de Convenções</li>
        </ul>
        <p class="text-gray-600 mt-2">Para mais informações sobre a disponibilidade e reservas, entre em contato com a administração.</p>
    </div>

</main>

</body>
</html>
