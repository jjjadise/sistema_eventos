<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">
            Solicitar divulgação de evento
        </h1>

        <form method="POST" class="space-y-3">
            @csrf

            <input name="title" placeholder="Título"
                   class="border rounded px-3 py-2 w-full">

            <textarea name="description" placeholder="Descrição"
                      class="border rounded px-3 py-2 w-full"></textarea>

            <input name="location" placeholder="Local"
                   class="border rounded px-3 py-2 w-full">

            <input type="datetime-local" name="event_date"
                   class="border rounded px-3 py-2 w-full">

            <select name="category_id"
                    class="border rounded px-3 py-2 w-full">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button class="bg-black text-white px-4 py-2 rounded">
                Enviar evento
            </button>
        </form>

    </div>
</x-app-layout>