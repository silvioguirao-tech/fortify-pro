<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Celtas') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-500 min-h-screen">

<x-nav />


<main class="py-10">
    @yield('content')
</main>

</body>
</html>
