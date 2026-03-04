<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Divulgar Evento</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">

<div class="max-w-3xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-semibold mb-6">
        Solicitar Divulgação de Evento
    </h1>

    {{-- MENSAGEM DE SUCESSO --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROS DE VALIDAÇÃO --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('events.store') }}"
          enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm p-6 border space-y-6">

        @csrf

        
        {{-- informacoes gerais --}}
        
        <div class="space-y-4">

            <h2 class="text-lg font-semibold border-b pb-2">
                Informações Gerais
            </h2>

            <input type="text"
                   name="title"
                   placeholder="Título do evento"
                   value="{{ old('title') }}"
                   class="w-full border rounded-lg px-3 py-2"
                   required>

            <textarea name="description"
                      placeholder="Descrição"
                      rows="4"
                      class="w-full border rounded-lg px-3 py-2"
                      required>{{ old('description') }}</textarea>

            <select name="category_id"
                    class="w-full border rounded-lg px-3 py-2"
                    required>
                <option value="">Selecione uma categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="campus_id"
                    class="w-full border rounded-lg px-3 py-2"
                    required>
                <option value="">Selecione o campus</option>
                @foreach ($campuses as $campus)
                    <option value="{{ $campus->id }}"
                        {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                        {{ $campus->name }}
                    </option>
                @endforeach
            </select>

            <select name="knowledge_area_id"
                    class="w-full border rounded-lg px-3 py-2"
                    required>
                <option value="">Selecione a área do conhecimento</option>
                @foreach ($knowledgeAreas as $area)
                    <option value="{{ $area->id }}"
                        {{ old('knowledge_area_id') == $area->id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>

            <select name="modality"
                    class="w-full border rounded-lg px-3 py-2"
                    required>
                <option value="">Modalidade</option>
                <option value="presencial" {{ old('modality') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="online" {{ old('modality') == 'online' ? 'selected' : '' }}>Online</option>
                <option value="hibrido" {{ old('modality') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
            </select>

            <input name="event_link"
                   placeholder="Link do evento"
                   value="{{ old('event_link') }}"
                   class="w-full border rounded-lg px-3 py-2"
                   required>

        </div>

       
        {{-- data local --}}
       
        <div class="space-y-4">

            <h2 class="text-lg font-semibold border-b pb-2">
                Data e Local
            </h2>

            <input name="location"
                   placeholder="Local"
                   value="{{ old('location') }}"
                   class="w-full border rounded-lg px-3 py-2"
                   required>

            <input name="address"
                   placeholder="Endereço (se presencial)"
                   value="{{ old('address') }}"
                   class="w-full border rounded-lg px-3 py-2">

            <input type="datetime-local"
                   name="event_date"
                   value="{{ old('event_date') }}"
                   class="w-full border rounded-lg px-3 py-2"
                   required>

            <div>
                <label class="text-sm text-gray-600 block mb-1">
                    Banner do evento
                </label>
                <input type="file"
                       name="banner"
                       accept="image/*"
                       class="w-full border rounded-lg px-3 py-2 bg-white"
                       required>
            </div>

            <input name="banner_alt_text"
                   placeholder="Texto alternativo do banner"
                   value="{{ old('banner_alt_text') }}"
                   class="w-full border rounded-lg px-3 py-2"
                   required>

        </div>

       
        {{-- inscricao--}}
       
        <div class="space-y-4">

            <h2 class="text-lg font-semibold border-b pb-2">
                Inscrição
            </h2>

            <div>
                <label class="font-medium block mb-2">
                    O evento é:
                </label>

                <label class="mr-4">
                    <input type="radio" name="is_paid" value="0"
                        {{ old('is_paid') == '0' ? 'checked' : '' }} required>
                    Gratuito
                </label>

                <label>
                    <input type="radio" name="is_paid" value="1"
                        {{ old('is_paid') == '1' ? 'checked' : '' }} required>
                    Pago
                </label>
            </div>

            <input name="registration_link"
                   placeholder="Link para inscrição (opcional)"
                   value="{{ old('registration_link') }}"
                   class="w-full border rounded-lg px-3 py-2">

        </div>

       
        {{-- acessibilidade --}}
      
        <div class="space-y-4">

            <h2 class="text-lg font-semibold border-b pb-2">
                Acessibilidade
            </h2>

            <div>
                <label class="font-medium block mb-2">
                    Terá intérprete de Libras?
                </label>

                <label class="mr-4">
                    <input type="radio" name="has_interpreter" value="1"
                        {{ old('has_interpreter') == '1' ? 'checked' : '' }} required>
                    Sim
                </label>

                <label>
                    <input type="radio" name="has_interpreter" value="0"
                        {{ old('has_interpreter') == '0' ? 'checked' : '' }} required>
                    Não
                </label>
            </div>

            <div>
                <label class="font-medium block mb-2">
                    Local acessível para cadeirantes?
                </label>

                <label class="mr-4">
                    <input type="radio" name="is_accessible" value="1"
                        {{ old('is_accessible') == '1' ? 'checked' : '' }} required>
                    Sim
                </label>

                <label>
                    <input type="radio" name="is_accessible" value="0"
                        {{ old('is_accessible') == '0' ? 'checked' : '' }} required>
                    Não
                </label>
            </div>

            <textarea name="accessibility_notes"
                      placeholder="Observações adicionais"
                      rows="3"
                      class="w-full border rounded-lg px-3 py-2">{{ old('accessibility_notes') }}</textarea>

        </div>

        {{-- responsável --}}
        <div class="space-y-4">

            <h2 class="text-lg font-semibold border-b pb-2">
                Responsável pelo Evento
            </h2>

            <input name="responsible_name"
                   placeholder="Nome do responsável"
                   value="{{ old('responsible_name') }}"
                   class="w-full border rounded-lg px-3 py-2"
                   required>

            <input name="responsible_phone"
                   placeholder="Telefone"
                   value="{{ old('responsible_phone') }}"
                   class="w-full border rounded-lg px-3 py-2"
                   required>

            <input type="email"
                   name="responsible_email"
                   placeholder="Email"
                   value="{{ old('responsible_email') }}"
                   class="w-full border rounded-lg px-3 py-2"
                   required>

        </div>

        <button class="bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition w-full">
            Enviar para aprovação
        </button>

    </form>

</div>

</body>
</html>