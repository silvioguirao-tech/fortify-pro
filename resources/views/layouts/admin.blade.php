<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-green-900 text-white p-6">
        <h2 class="text-xl font-bold mb-6">Painel Admin</h2>

        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block hover:text-gray-300">
                Dashboard
            </a>
        </nav>
    </aside>

    <!-- Conteúdo -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

</body>
</html>
