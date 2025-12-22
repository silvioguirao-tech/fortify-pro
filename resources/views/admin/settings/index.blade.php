@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Configurações</h1>

<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4 bg-white p-6 rounded">
    @csrf

    <label class="flex items-center gap-4">
        <input type="checkbox" name="require_2fa_for_all" value="1" @if($require2fa) checked @endif>
        <span>Exigir 2FA para todos os usuários</span>
    </label>

    <label class="flex items-center gap-4">
        <input type="checkbox" name="email_verification_required" value="1" @if($emailVerification) checked @endif>
        <span>Exigir verificação por e-mail</span>
    </label>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>

    @if($require2fa)
        <form method="POST" action="{{ route('admin.settings.apply_2fa') }}" class="mt-4">
            @csrf
            <button class="bg-yellow-600 text-white px-4 py-2 rounded">Aplicar 'Exigir 2FA' para todos os usuários</button>
        </form>
    @endif
</form>

<hr class="my-6">
<h2 class="text-xl font-semibold mb-2">Últimas ações de admin</h2>
<ul class="bg-white p-4 rounded">
    @foreach($actions as $a)
        <li class="text-sm">[{{ $a->created_at->toDateTimeString() }}] <strong>{{ $a->admin->name }}</strong> → {{ $a->action }} <span class="text-gray-500">{{ json_encode($a->meta) }}</span></li>
    @endforeach
</ul>
@endsection