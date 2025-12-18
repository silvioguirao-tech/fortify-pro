@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Nova senha</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="block mb-1">E-mail</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                class="w-full border rounded px-3 py-2"
            >
        </div>

        <div>
            <label class="block mb-1">Nova senha</label>
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

        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Redefinir senha
        </button>
    </form>
</div>
@endsection
