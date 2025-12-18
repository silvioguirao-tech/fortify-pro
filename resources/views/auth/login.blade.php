@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Entrar</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
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

        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Entrar
        </button>
    </form>
</div>
@endsection
