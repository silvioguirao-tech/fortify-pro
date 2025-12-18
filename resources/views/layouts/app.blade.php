<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Celtas') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-500 min-h-screen">

<nav class="bg-celtas-primary text-white">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="text-xl font-bold tracking-wide">
            CELTAS
        </div>

        @auth
        <div class="flex items-center gap-6 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline">
                Dashboard
            </a>

            <a href="/two-factor" class="hover:underline">
                Segurança
            </a>

            @if(auth()->user()->isAdmin())
                <a href="/admin" class="hover:underline">
                    Admin
                </a>
            @endif

            <span class="opacity-80">
                {{ auth()->user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-green-700 text-celtas-primary px-3 py-1 rounded hover:bg-green-100">
                    Sair
                </button>
            </form>
        </div>
        @endauth
    </div>
</nav>


<main class="py-10">
    @yield('content')
</main>

</body>
</html>
