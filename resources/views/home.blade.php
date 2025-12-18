<x-app-layout>
    <h1 class="text-2xl font-bold">Área do Usuário</h1>
    <p class="mt-2 text-gray-600">
        Bem-vindo, {{ auth()->user()->name }}!
    </p>
</x-app-layout>
