@extends('layouts.app')

@section('content')
<x-card class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Meu Perfil</h1>

    @if (session('status') === '2fa-enabled')
        <x-alert type="success" class="mb-4">Autenticação de dois fatores ativada.</x-alert>
    @endif

    @if (session('status') === '2fa-disabled')
        <x-alert type="success" class="mb-4">Autenticação de dois fatores desativada.</x-alert>
    @endif

    <div class="mb-6">
        <h2 class="font-semibold">Informações</h2>
        <p class="text-sm text-gray-600">Nome: {{ $user->name }}</p>
        <p class="text-sm text-gray-600">E-mail: {{ $user->email }}</p>
    </div>

    <div>
        <h2 class="font-semibold mb-2">Autenticação de dois fatores (2FA)</h2>

        @if ($user->two_factor_enabled)
            <p class="text-sm text-gray-700 mb-4">2FA está <strong>ATIVADA</strong>.</p>

            <form method="POST" action="{{ route('aluno.profile.2fa.disable') }}">
                @csrf
                <x-button variant="danger">Desativar 2FA</x-button>
            </form>

            <div class="mt-4 text-sm">
                <p>Recupere seus códigos com o administrador se perder o acesso.</p>
            </div>
        @else
            <p class="text-sm text-gray-700 mb-4">2FA está <strong>DESATIVADA</strong>.</p>

            <form method="POST" action="{{ route('aluno.profile.2fa.enable') }}">
                @csrf
                <x-button variant="primary">Ativar 2FA</x-button>
            </form>

            <div class="mt-4 text-sm text-gray-600">Ao ativar 2FA, códigos de recuperação serão gerados e exibidos no perfil.</div>
        @endif
    </div>
</x-card>
@endsection
