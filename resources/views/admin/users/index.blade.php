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
    <th>Ações</th>
</tr>
@foreach($users as $user)
<tr>
    <td class="p-2">{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role }}</td>
    <td class="space-x-2">
        <a href="{{ route('admin.users.edit', $user) }}">Editar</a>
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
