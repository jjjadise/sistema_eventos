<!DOCTYPE html>
<html>
<head>
    <title>Enviar Evento</title>
</head>
<body>
    <h1>Solicitar Divulgação de Evento</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('events.store') }}">
        @csrf
        <label>Título:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>Local:</label><br>
        <input type="text" name="location" required><br><br>

        <label>Data do Evento:</label><br>
        <input type="datetime-local" name="event_date" required><br><br>

        <button type="submit">Enviar Evento</button>
    </form>
</body>
</html>
