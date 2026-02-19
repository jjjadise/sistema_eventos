<?php

use App\Models\Event;
use Livewire\Volt\Component;

new class extends Component {

    public string $title = '';
    public string $description = '';
    public string $location = '';
    public string $event_date = '';
    public ?string $successMessage = null;

    public function submit()
    {
        $this->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
        ]);

        Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'event_date' => $this->event_date,
            'status' => 'pendente',
        ]);

        $this->reset(['title','description','location','event_date']);
        $this->successMessage = 'Evento enviado com sucesso!';
    }

}; ?>

<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow mt-10">

    <h1 class="text-2xl font-bold mb-6">Solicitar Divulgação de Evento</h1>

    @if ($successMessage)
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit="submit">

        <div class="mb-4">
            <input type="text" wire:model="title" placeholder="Título"
                   class="w-full border p-2 rounded">
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <textarea wire:model="description" placeholder="Descrição"
                      class="w-full border p-2 rounded"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <input type="text" wire:model="location" placeholder="Local"
                   class="w-full border p-2 rounded">
            @error('location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <input type="datetime-local" wire:model="event_date"
                   class="w-full border p-2 rounded">
            @error('event_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded">
            Enviar Evento
        </button>

    </form>

</div>
