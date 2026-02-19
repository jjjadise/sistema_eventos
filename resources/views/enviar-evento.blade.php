<!DOCTYPE html>
<html>
<head>
    <title>Enviar Evento</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 p-10">

    <x-public-event-form />

    @livewireScripts
</body>
</html>
