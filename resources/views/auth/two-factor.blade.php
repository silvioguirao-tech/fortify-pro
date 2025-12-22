@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Autenticação em dois fatores</h1>

    @if (session('status'))
        <div class="mb-4 text-green-600">
            {{ session('status') }}
        </div>
    @endif

    @php
        $require2fa = \App\Models\Setting::get('require_2fa_for_all', '0');
        $userRequired = auth()->user()->two_factor_required ?? false;
    @endphp

    @if($require2fa || $userRequired)
        <div class="mb-4 border-l-4 p-4 bg-yellow-100 border-yellow-300 rounded">
            <strong>Atenção:</strong> A administração requisitou que você ative a autenticação de dois fatores para continuar acessando certas áreas. Por favor, configure sua 2FA abaixo.
        </div>
    @endif

    {{-- Ativar 2FA --}}
    @if (! auth()->user()->two_factor_secret)
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
            @csrf

            <p class="mb-4">
                A autenticação em dois fatores adiciona uma camada extra de segurança.
            </p>

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Ativar 2FA
            </button>
        </form>
    @else
        {{-- QR Code --}}
        <div class="mb-6">
            <p class="mb-2 font-semibold">Escaneie o QR Code:</p>
            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        </div>

        {{-- Recovery Codes --}}
        <div class="mb-6">
            <p class="mb-2 font-semibold">Códigos de recuperação:</p>
            <ul class="bg-gray-100 p-4 rounded text-sm">
                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        </div>

        {{-- Desativar --}}
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
            @csrf
            @method('DELETE')

            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Desativar 2FA
            </button>
        </form>
    @endif
</div>
@endsection
