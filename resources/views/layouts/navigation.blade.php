<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-purple-700">
                    {{ config('app.name', 'AppelOffresSN') }}
                </a>
            </div>

            <!-- Menu principal -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <a href="{{ route('home') }}" class="text-gray-800 hover:text-purple-700">Accueil</a>

                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-purple-800 font-semibold hover:underline">
                            Tableau de bord Admin
                        </a>
                    @endif

                    <a href="#" class="text-gray-800">{{ auth()->user()->name }}</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-800 hover:text-purple-700">Connexion</a>
                    <a href="{{ route('register') }}" class="text-purple-800 font-semibold hover:underline">Inscription</a>
                @endauth
            </div>

            <!-- Menu mobile -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile déroulant -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-800 hover:bg-purple-100">Accueil</a>

            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-purple-800 font-semibold hover:bg-purple-100">
                        Tableau de bord Admin
                    </a>
                @endif

                <a href="#" class="block px-4 py-2 text-gray-800">{{ auth()->user()->name }}</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-800 hover:bg-purple-100">Connexion</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 text-purple-800 font-semibold hover:bg-purple-100">Inscription</a>
            @endauth
        </div>
    </div>
</nav>
