@extends('layouts.app')

@section('content')
<x-card class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-center">Entrar</h1>

    @if ($errors->any())
        <x-alert type="error" class="mb-4">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </x-alert>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">E-mail</label>
            <input
                type="email"
                name="email"
                required
                autofocus
                class="w-full border rounded px-3 py-2"
            >
        </div>

        <div>
            <label class="block mb-1">Senha</label>
            <input
                type="password"
                name="password"
                required
                class="w-full border rounded px-3 py-2"
            >
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                Lembrar-me
            </label>

            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                Esqueceu a senha?
            </a>
        </div>

        <x-button class="w-full">Entrar</x-button>
    </form>
</x-card>
@endsection
