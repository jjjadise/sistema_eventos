<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Divulgar Evento</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">

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

    <form method="POST"
          action="{{ route('events.store') }}"
          enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm p-6 border space-y-4">

        @csrf

        <input name="title"
               placeholder="Título do evento"
               class="w-full border rounded-lg px-3 py-2"
               required>

        <textarea name="description"
                  placeholder="Descrição"
                  class="w-full border rounded-lg px-3 py-2"
                  rows="4"
                  required></textarea>

        <input name="location"
               placeholder="Local"
               class="w-full border rounded-lg px-3 py-2"
               required>

        <input type="datetime-local"
               name="event_date"
               class="w-full border rounded-lg px-3 py-2"
               required>

        <select name="category_id"
                class="w-full border rounded-lg px-3 py-2">
            <option value="">Selecione uma categoria</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <div>
            <label class="text-sm text-gray-600 block mb-1">
                Banner do evento (opcional)
            </label>
            <input type="file"
                   name="banner"
                   accept="image/*"
                   class="w-full border rounded-lg px-3 py-2 bg-white">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Enviar para aprovação
        </button>

    </form>

</div>

</body>
</html>
 









</body>
</html>