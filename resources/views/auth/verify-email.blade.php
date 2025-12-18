@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow text-center">
    <h1 class="text-2xl font-bold mb-4">Verifique seu e-mail</h1>

    <p class="mb-4">
        Obrigado por se registrar! Antes de continuar,
        verifique seu e-mail clicando no link que enviamos.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-green-600">
            Um novo link de verificação foi enviado.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Reenviar e-mail de verificação
        </button>
    </form>
</div>
@endsection
