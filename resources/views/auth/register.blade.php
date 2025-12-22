@extends('layouts.app')

@section('content')
<x-card class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-center">Criar conta</h1>

    @if ($errors->any())
        <x-alert type="error" class="mb-4">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </x-alert>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Nome</label>
            <input
                type="text"
                name="name"
                required
                class="w-full border rounded px-3 py-2"
            >
        </div>

        <div>
            <label class="block mb-1">E-mail</label>
            <input
                type="email"
                name="email"
                required
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

        <div>
            <label class="block mb-1">Confirmar senha</label>
            <input
                type="password"
                name="password_confirmation"
                required
                class="w-full border rounded px-3 py-2"
            >
        </div>

        <x-button class="w-full" variant="primary">Registrar</x-button>
    </form>
</x-card>
@endsection
