<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divulgar Evento - Sistema de Eventos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">

<header class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="font-bold text-lg text-blue-600">Sistema de Eventos</div>
        <nav class="flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition">Eventos</a>
            <a href="{{ route('venues.index') }}" class="text-gray-500 hover:text-gray-900 transition">Espaços</a>
            <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">
                + Divulgar Evento
            </a>
        </nav>
    </div>
</header>

<main class="max-w-2xl mx-auto px-4 py-10">

    <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline mb-6 inline-block">
        ← Voltar
    </a>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Solicitar divulgação de evento</h1>
        <p class="text-sm text-gray-500 mt-1">Preencha as informações abaixo e aguarde a aprovação da equipe.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
            <strong>Corrija os erros abaixo:</strong>
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Responsável --}}
        <div class="bg-white rounded-2xl border shadow-sm p-6 space-y-4">
            <h2 class="font-semibold text-gray-800 text-base border-b pb-2">👤 Dados do Responsável</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome completo *</label>
                <input type="text" name="responsible_name" value="{{ old('responsible_name') }}" required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
                    <input type="email" name="responsible_email" value="{{ old('responsible_email') }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefone *</label>
                    <input type="text" name="responsible_phone" value="{{ old('responsible_phone') }}" required
                           placeholder="(85) 99999-9999"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        {{-- Informações Gerais --}}
        <div class="bg-white rounded-2xl border shadow-sm p-6 space-y-4">
            <h2 class="font-semibold text-gray-800 text-base border-b pb-2">📋 Informações Gerais</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título do evento *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descrição *</label>
                <textarea name="description" rows="4" required
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoria *</label>
                    <select name="category_id" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    
                <label class="block text-sm font-medium text-gray-700 mb-1">Modalidade *</label>
                    
              <select name="modality" required onchange="toggleAddress(this.value)"

                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione</option>
                        <option value="presencial" {{ old('modality') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="online" {{ old('modality') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="hibrido" {{ old('modality') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Campus *</label>
                    <select name="campus_id" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione</option>
                        @foreach ($campuses as $campus)
                            <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                                {{ $campus->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Área do Conhecimento *</label>
                    <select name="knowledge_area_id" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione</option>
                        @foreach ($knowledgeAreas as $area)
                            <option value="{{ $area->id }}" {{ old('knowledge_area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link do evento</label>
                <input type="url" name="event_link" value="{{ old('event_link') }}"
                       placeholder="https://"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Data e Local --}}
        <div class="bg-white rounded-2xl border shadow-sm p-6 space-y-4">
            <h2 class="font-semibold text-gray-800 text-base border-b pb-2">📍 Data e Local</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Local *</label>
                    <input type="text" name="location" value="{{ old('location') }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data e hora *</label>
                    <input type="datetime-local" name="event_date" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

           <div id="field-address" style="{{ old('modality') == 'online' ? 'display:none' : '' }}">
    <label class="block text-sm font-medium text-gray-700 mb-1">Endereço completo *</label>
    <input type="text" name="address" id="input-address" value="{{ old('address') }}"
                       placeholder="Ex: Av. da Universidade, 2853 - Benfica, Fortaleza - CE"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Banner do evento</label>
                <input type="file" name="banner" accept="image/*"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-600 file:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Texto alternativo do banner (acessibilidade)</label>
                <input type="text" name="banner_alt_text" value="{{ old('banner_alt_text') }}"
                       placeholder="Ex: Banner do evento de Biologia"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Inscrição --}}
        <div class="bg-white rounded-2xl border shadow-sm p-6 space-y-4">
            <h2 class="font-semibold text-gray-800 text-base border-b pb-2">🎟️ Inscrição</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">O evento é: *</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="radio" name="is_paid" value="0" {{ old('is_paid') === '0' ? 'checked' : '' }} required>
                        Gratuito
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="radio" name="is_paid" value="1" {{ old('is_paid') === '1' ? 'checked' : '' }} required>
                        Pago
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link para inscrição</label>
                <input type="url" name="registration_link" value="{{ old('registration_link') }}"
                       placeholder="https://"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Acessibilidade --}}
        <div class="bg-white rounded-2xl border shadow-sm p-6 space-y-4">
            <h2 class="font-semibold text-gray-800 text-base border-b pb-2">♿ Acessibilidade</h2>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Intérprete de Libras? *</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="radio" name="has_interpreter" value="1" {{ old('has_interpreter') === '1' ? 'checked' : '' }} required>
                            Sim
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="radio" name="has_interpreter" value="0" {{ old('has_interpreter') === '0' ? 'checked' : '' }} required>
                            Não
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Local acessível? *</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="radio" name="is_accessible" value="1" {{ old('is_accessible') === '1' ? 'checked' : '' }} required>
                            Sim
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="radio" name="is_accessible" value="0" {{ old('is_accessible') === '0' ? 'checked' : '' }} required>
                            Não
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Observações sobre acessibilidade</label>
                <textarea name="accessibility_notes" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('accessibility_notes') }}</textarea>
            </div>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition text-sm">
            Enviar para aprovação →
        </button>

    </form>
</main>

<footer class="mt-16 border-t bg-white py-6 text-center text-sm text-gray-400">
    Sistema de Eventos © {{ date('Y') }}
</footer>

<script>
function toggleAddress(modality) {
    const field = document.getElementById('field-address');
    const input = document.getElementById('input-address');
    if (modality === 'online') {
        field.style.display = 'none';
        input.removeAttribute('required');
    } else {
        field.style.display = 'block';
        input.setAttribute('required', 'required');
    }
}
</script>

</body>
</html>
