@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Usuários</h1>

@can('user.create')
<a href="{{ route('admin.users.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
   Novo Usuário
</a>
@endcan

<table class="w-full mt-4 bg-white shadow rounded">
<tr>
    <th class="p-2">Nome</th>
    <th>Email</th>
    <th>Role</th>
    <th>Verificado</th>
    <th>2FA</th>
    <th>Ações</th>
</tr>
@foreach($users as $user)
<tr>
    <td class="p-2">{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->getRoleNames()->first() ?? '-' }}</td>
    <td class="px-2">@if($user->email_verified_at) <span class="text-green-600">Sim</span> @else <span class="text-gray-600">Não</span> @endif</td>
    <td class="px-2">@if($user->two_factor_enabled) <span class="text-green-600">Ativado</span> @else <span class="text-gray-600">Desativado</span> @endif</td>
    <td class="space-x-2">
        <a href="{{ route('admin.users.edit', $user) }}">Editar</a>

        <form method="POST" action="{{ route('admin.users.toggle_email_verification', $user) }}" class="inline">
            @csrf
            <button class="text-sm px-2 py-1 bg-gray-100 rounded">@if($user->email_verified_at) Desmarcar verificado @else Marcar verificado @endif</button>
        </form>

        <form method="POST" action="{{ route('admin.users.toggle_two_factor', $user) }}" class="inline">
            @csrf
            <button class="text-sm px-2 py-1 bg-gray-100 rounded">@if($user->two_factor_enabled) Desativar 2FA @else Ativar 2FA @endif</button>
        </form>

        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
            @csrf @method('DELETE')
            @can('user.delete')
            <button class="text-red-600">Excluir</button>
            @endcan
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection
