@extends('layouts.app')

@section('content')
<x-celtas-card>
    <div>
        <h2 class="font-semibold text-lg mb-2">Área do aluno</h2>
        <p class="text-gray-600">Conteúdos, materiais e simulados</p>
    </div>
</x-celtas-card>

@if(auth()->user()->isAdmin())
<x-celtas-card>
    <div>
        <h2 class="font-semibold text-lg mb-2">Administração</h2>
        <p class="text-gray-600">Gerenciar alunos e conteúdos</p>
    </div>
</x-celtas-card>
@endif

<x-celtas-card>
    <div>
        <h2 class="font-semibold text-lg mb-2">Segurança</h2>
        <p class="text-gray-600">Senha, 2FA e acesso</p>
    </div>
</x-celtas-card>

@endsection
