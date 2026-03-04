<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">
            Solicitar divulgação de evento
        </h1>

        <form method="POST"
              action="{{ route('events.store') }}"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf

            {{-- ===================== --}}
            {{-- INFORMAÇÕES GERAIS --}}
            {{-- ===================== --}}

            <div class="bg-white p-6 rounded-xl shadow space-y-4">

                <h2 class="font-semibold text-lg">
                    Informações Gerais
                </h2>

                <input type="email"
                       name="contact_email"
                       placeholder="Seu e-mail"
                       required
                       class="border rounded px-3 py-2 w-full">

                <input name="title"
                       placeholder="Título do evento"
                       required
                       class="border rounded px-3 py-2 w-full">

                <textarea name="description"
                          placeholder="Descrição"
                          required
                          rows="4"
                          class="border rounded px-3 py-2 w-full"></textarea>

                <select name="category_id"
                        required
                        class="border rounded px-3 py-2 w-full">
                    <option value="">Selecione uma categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <input name="event_link"
                       placeholder="Link do evento (opcional)"
                       class="border rounded px-3 py-2 w-full">

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Modalidade
                    </label>
                    <select name="modality"
                            required
                            class="border rounded px-3 py-2 w-full">
                        <option value="">Selecione</option>
                        <option value="presencial">Presencial</option>
                        <option value="online">Online</option>
                        <option value="hibrido">Híbrido</option>
                    </select>
                </div>

            </div>

            {{-- ===================== --}}
            {{-- DATA E LOCAL --}}
            {{-- ===================== --}}

            <div class="bg-white p-6 rounded-xl shadow space-y-4">

                <h2 class="font-semibold text-lg">
                    Data e Local
                </h2>

                <input name="location"
                       placeholder="Local"
                       required
                       class="border rounded px-3 py-2 w-full">

                <input type="datetime-local"
                       name="event_date"
                       required
                       class="border rounded px-3 py-2 w-full">

                <input type="file"
                       name="banner"
                       accept="image/*"
                       class="border rounded px-3 py-2 w-full">

            </div>

            {{-- ===================== --}}
            {{-- INSCRIÇÃO --}}
            {{-- ===================== --}}

            <div class="bg-white p-6 rounded-xl shadow space-y-4">

                <h2 class="font-semibold text-lg">
                    Inscrição
                </h2>

                <div class="space-y-2">
                    <label class="font-medium">O evento é:</label>
                    <div>
                        <label class="mr-4">
                            <input type="radio" name="is_paid" value="0" required>
                            Gratuito
                        </label>

                        <label>
                            <input type="radio" name="is_paid" value="1" required>
                            Pago
                        </label>
                    </div>
                </div>

                <input name="registration_link"
                       placeholder="Link para inscrição (opcional)"
                       class="border rounded px-3 py-2 w-full">

            </div>

            {{-- ===================== --}}
            {{-- ACESSIBILIDADE --}}
            {{-- ===================== --}}

            <div class="bg-white p-6 rounded-xl shadow space-y-4">

                <h2 class="font-semibold text-lg">
                    Acessibilidade
                </h2>

                <div>
                    <label class="font-medium block mb-1">
                        Terá intérprete de Libras?
                    </label>

                    <label class="mr-4">
                        <input type="radio" name="has_interpreter" value="1" required>
                        Sim
                    </label>

                    <label>
                        <input type="radio" name="has_interpreter" value="0" required>
                        Não
                    </label>
                </div>

                <div>
                    <label class="font-medium block mb-1">
                        Local acessível para cadeirantes?
                    </label>

                    <label class="mr-4">
                        <input type="radio" name="is_accessible" value="1" required>
                        Sim
                    </label>

                    <label>
                        <input type="radio" name="is_accessible" value="0" required>
                        Não
                    </label>
                </div>

                <textarea name="accessibility_notes"
                          placeholder="Observações sobre acessibilidade (opcional)"
                          rows="3"
                          class="border rounded px-3 py-2 w-full"></textarea>

            </div>

            <button class="bg-black text-white px-6 py-3 rounded-lg w-full">
                Enviar evento para aprovação
            </button>

        </form>

    </div>
</x-app-layout>