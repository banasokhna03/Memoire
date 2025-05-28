@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header with filters -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h1 class="text-3xl font-bold text-purple-800 flex items-center">
                <i class="fas fa-archive mr-3 text-yellow-500"></i> Archive des Offres
            </h1>
            <div class="mt-4 md:mt-0">
                <form method="GET" action="{{ route('offers.archive') }}">
                    <select name="type" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Toutes les offres archivées</option>
                        <option value="public" {{ request('type') == 'public' ? 'selected' : '' }}>Offres publiques</option>
                        <option value="privé" {{ request('type') == 'privé' ? 'selected' : '' }}>Offres privées</option>
                        <option value="international" {{ request('type') == 'international' ? 'selected' : '' }}>Offres internationales</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Search and sort -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('offers.archive') }}">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Rechercher une offre archivées...">
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-600">Trier par :</span>
                        <select name="sort" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-purple-500 focus:border-purple-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récentes</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciennes</option>
                            <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Date limite (proche)</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Message spécial archive -->
    <div class="bg-purple-100 text-purple-800 p-4 rounded mb-6 text-center">
        Vous consultez ici les offres dont la date limite est dépassée.
    </div>

    <!-- Le reste du code reste identique à index.blade.php pour afficher la liste des offres -->
    @if($offers->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow-sm text-center">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-600">Aucune offre archivée disponible</h3>
            <p class="text-gray-500 mt-2">Aucune offre archivée ne correspond à vos critères de recherche.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($offers as $offer)
                <div class="offer-card bg-white p-6 rounded-lg shadow-sm">
                    <!-- Contenu de la carte identique à index -->
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-white text-xs px-3 py-1 rounded-full 
                            @if($offer->type == 'public') bg-blue-500 @endif
                            @if($offer->type == 'privé') bg-green-500 @endif
                            @if($offer->type == 'international') bg-yellow-500 @endif">
                            {{ ucfirst($offer->type) }}
                        </span>
                        <span class="text-xs text-gray-500">Publiée le {{ $offer->created_at->format('d/m/Y') }}</span>
                    </div>
                    <h3 class="text-xl font-semibold text-purple-800 mb-2">{{ $offer->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($offer->description, 120) }}</p>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">{{ $offer->sector }}</span>
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">{{ $offer->region }}</span>
                        @if($offer->budget)
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Budget: {{ number_format($offer->budget, 0, ',', ' ') }} FCFA</span>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-yellow-500 mr-2"></i>
                            <span class="text-xs font-medium">Clôture: {{ $offer->deadline->format('d/m/Y') }}</span>
                        </div>
                        <a href="{{ route('offers.show', $offer->id) }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Voir détails <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination (identique à index) -->
        <div class="mt-10 flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Affichage <span class="font-medium">{{ $offers->firstItem() }}</span> à <span class="font-medium">{{ $offers->lastItem() }}</span> sur <span class="font-medium">{{ $offers->total() }}</span> offres archivées
            </div>
            <div class="flex space-x-2">
                @if($offers->onFirstPage())
                    <span class="px-3 py-1 rounded-lg border border-gray-300 bg-gray-100 text-gray-400">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $offers->previousPageUrl() }}" class="px-3 py-1 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                @foreach(range(1, $offers->lastPage()) as $page)
                    @if($page == $offers->currentPage())
                        <span class="px-3 py-1 rounded-lg bg-purple-600 text-white font-medium">{{ $page }}</span>
                    @else
                        <a href="{{ $offers->url($page) }}" class="px-3 py-1 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                @if($offers->hasMorePages())
                    <a href="{{ $offers->nextPageUrl() }}" class="px-3 py-1 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="px-3 py-1 rounded-lg border border-gray-300 bg-gray-100 text-gray-400">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    @endif
</main>
@endsection
