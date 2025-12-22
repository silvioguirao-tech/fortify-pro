<nav class="bg-celtas-primary text-white">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="text-xl font-bold tracking-wide">
            <a href="{{ url('/') }}" class="hover:underline">{{ config('app.name', 'Celtas') }}</a>
        </div>

        <div class="flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <a href="/cursos" class="hover:underline">Cursos</a>
            <a href="/sobre" class="hover:underline">Sobre</a>

            @auth
                <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>

                @if(auth()->user()->hasRole('admin'))
                    <a href="/admin" class="hover:underline">Admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="bg-green-700 text-celtas-primary px-3 py-1 rounded hover:bg-green-100">Sair</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline">Entrar</a>
                <a href="{{ route('register') }}" class="hover:underline">Registrar</a>
            @endauth
        </div>
    </div>
</nav>
