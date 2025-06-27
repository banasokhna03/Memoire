<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | AppelOffresSN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .admin-nav {
            scrollbar-width: thin;
            scrollbar-color: #8b5cf6 #f5f3ff;
        }
        .admin-nav::-webkit-scrollbar {
            width: 6px;
        }
        .admin-nav::-webkit-scrollbar-track {
            background: #f5f3ff;
        }
        .admin-nav::-webkit-scrollbar-thumb {
            background-color: #8b5cf6;
            border-radius: 3px;
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }
        .blink-warning {
            animation: blink 2s infinite;
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800" x-data="adminApp()">
    <!-- Admin Layout -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-purple-800 border-r border-purple-700">
                <div class="flex items-center h-16 px-4 bg-purple-900">
<a href="{{ url('/') }}" class="flex items-center space-x-2">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
</a>                    
<span class="text-white font-bold">Admin Portal</span>
                </div>
                <div class="admin-nav flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <!-- Dashboard -->
                        <a href="#" @click="currentTab = 'dashboard'" :class="{'bg-purple-700': currentTab === 'dashboard'}" class="group flex items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Tableau de bord
                        </a>

                        <!-- User Management -->
                        <div x-data="{ userOpen: false }">
                            <button @click="userOpen = !userOpen" class="w-full flex justify-between items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                                <div class="flex items-center">
                                    <i class="fas fa-users-cog mr-3"></i>
                                    Gestion Utilisateurs
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'transform rotate-180': userOpen }"></i>
                            </button>
                            <div x-show="userOpen" class="mt-1 space-y-1 pl-12">
                                <a href="#" @click="currentTab = 'users'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Liste Utilisateurs</a>
                                <a href="#" @click="currentTab = 'createUser'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Créer Utilisateur</a>
                                <a href="#" @click="currentTab = 'roles'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Gestion Rôles</a>
                            </div>
                        </div>

                        <!-- Offer Management -->
                        <div x-data="{ offerOpen: false }">
                            <button @click="offerOpen = !offerOpen" class="w-full flex justify-between items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                                <div class="flex items-center">
                                    <i class="fas fa-file-contract mr-3"></i>
                                    Gestion Offres
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'transform rotate-180': offerOpen }"></i>
                            </button>
                            <div x-show="offerOpen" class="mt-1 space-y-1 pl-12">
                                <a href="#" @click="currentTab = 'pendingOffers'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Offres en Attente @if(isset($pendingOffersCount) && $pendingOffersCount > 0)<span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-1">{{ $pendingOffersCount }}</span>@endif</a>
                                <a href="#" @click="currentTab = 'activeOffers'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Offres Actives</a>
                                <a href="#" @click="currentTab = 'archivedOffers'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Archive</a>
                            </div>
                        </div>

                        <!-- Applications Management -->
                        <div x-data="{ applicationOpen: false }">
                            <button @click="applicationOpen = !applicationOpen" class="w-full flex justify-between items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                                <div class="flex items-center">
                                    <i class="fas fa-clipboard-list mr-3"></i>
                                    Candidatures
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'transform rotate-180': applicationOpen }"></i>
                            </button>
                            <div x-show="applicationOpen" class="mt-1 space-y-1 pl-12">
                                <a href="{{ route('admin.applications.index') }}" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Toutes les candidatures</a>
                                <a href="{{ route('admin.applications.index') }}?status=pending" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">En attente</a>
                                <a href="{{ route('admin.applications.index') }}?status=accepted" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Acceptées</a>
                                <a href="{{ route('admin.applications.index') }}?status=rejected" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Refusées</a>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <a href="#" @click="currentTab = 'stats'" :class="{'bg-purple-700': currentTab === 'stats'}" class="group flex items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                            <i class="fas fa-chart-pie mr-3"></i>
                            Statistiques
                        </a>

                        <!-- System -->
                        <div x-data="{ systemOpen: false }">
                            <button @click="systemOpen = !systemOpen" class="w-full flex justify-between items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                                <div class="flex items-center">
                                    <i class="fas fa-cogs mr-3"></i>
                                    Configuration
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'transform rotate-180': systemOpen }"></i>
                            </button>
                            <div x-show="systemOpen" class="mt-1 space-y-1 pl-12">
                                <a href="#" @click="currentTab = 'settings'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Paramètres</a>
                                <a href="{{ route('admin.activity-sectors.index') }}" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Secteurs d'activité</a>
                                <a href="#" @click="currentTab = 'backup'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Sauvegarde</a>
                                <a href="#" @click="currentTab = 'audit'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Journal d'audit</a>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="p-4 border-t border-purple-700">
                    <div class="flex items-center">
                        <div class="ml-3">
    <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
    <a href="{{ route('logout') }}" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="text-xs font-medium text-purple-200 hover:text-white">
        Déconnexion
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Mobile Topbar -->
            <div class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200">
                <button @click="mobileMenuOpen = true" class="text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-lg font-semibold" x-text="getTabTitle(currentTab)"></h1>
                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
            </div>

            <!-- Mobile Sidebar -->
            <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="fixed inset-0 z-40 md:hidden">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
                <div class="fixed inset-0 flex z-50">
                    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-purple-800">
                        <div class="absolute top-0 right-0 -mr-12 pt-2">
                            <button @click="mobileMenuOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none">
                                <i class="fas fa-times text-white text-xl"></i>
                            </button>
                        </div>
                        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                            <div class="flex-shrink-0 flex items-center px-4">
                                <img src="{{ asset('images/logo-white.png') }}" class="h-8 w-auto mr-2" alt="Logo">
                                <span class="text-white font-bold">Admin Portal</span>
                            </div>
                            <nav class="mt-5 px-2 space-y-1">
                                <!-- Mobile menu items same as desktop -->
                            </nav>
                        </div>
                        <div class="p-4 border-t border-purple-700">
                            <!-- Same user panel as desktop -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <main class="flex-1 pb-8">
                <!-- Dashboard Header -->
                <div class="bg-white shadow">
                    <div class="px-4 sm:px-6 lg:max-w-7xl lg:mx-auto lg:px-8">
                        <div class="py-6 flex items-center justify-between">
                            <h1 class="text-2xl font-bold text-gray-900" x-text="getTabTitle(currentTab)"></h1>
                            <div class="flex space-x-3">
                                <button class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700">
                                    <i class="fas fa-download mr-2"></i> Exporter
                                </button>
                                <button x-show="currentTab === 'pendingOffers'" class="bg-red-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-600 blink-warning" @if(!isset($pendingOffersCount) || $pendingOffersCount == 0) style="display: none;" @endif>
                                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ $pendingOffersCount ?? '0' }} en attente
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content Sections -->
                <div class="mt-8 px-4 sm:px-6 lg:max-w-7xl lg:mx-auto lg:px-8">
                    <!-- Dashboard Tab -->
                    <template x-if="currentTab === 'dashboard'">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Statistiques rapides -->
                            <div class="stat-card p-6 bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Offres en attente</h3>
                                    <div class="text-purple-600 bg-purple-100 p-3 rounded-full stat-icon transition-transform">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <p class="text-3xl font-bold text-gray-900">{{ $pendingOffersCount ?? 0 }}</p>
                                <p class="text-sm text-gray-500 mt-2">Offres nécessitant validation</p>
                                
                                @if(($pendingOffersCount ?? 0) > 0)
                                    <div class="mt-4">
                                        <a href="#" @click="currentTab = 'pendingOffers'" class="text-sm text-purple-600 hover:text-purple-800 font-medium inline-flex items-center">
                                            Voir les détails <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Statistiques des candidatures -->
                            <div class="stat-card p-6 bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Candidatures</h3>
                                    <div class="text-blue-600 bg-blue-100 p-3 rounded-full stat-icon transition-transform">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                </div>
                                <p class="text-3xl font-bold text-gray-900">{{ $pendingApplicationsCount ?? 0 }}</p>
                                <p class="text-sm text-gray-500 mt-2">Candidatures en attente de traitement</p>
                                
                                @if(($pendingApplicationsCount ?? 0) > 0)
                                    <div class="mt-4">
                                        <a href="{{ route('admin.applications.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                            Gérer les candidatures <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Section Offres en Attente -->
                        <div class="mt-8 mb-6">
                            <!-- Message de débogage -->
                            @if(session('debug'))
                            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                                <p class="font-bold">Information de débogage:</p>
                                <p>{{ session('debug') }}</p>
                            </div>
                            @endif

                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold text-gray-700">Offres en Attente de Validation</h2>
                                @if(isset($pendingOffers) && $pendingOffers->count() > 0)
                                    <a href="{{ route('admin.offers.pending') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                        Voir toutes les offres ({{ $pendingOffers->count() }})
                                        <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                @endif
                            </div>

                            @if(session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md shadow">
                                {{ session('success') }}
                            </div>
                            @endif

                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                @if(isset($pendingOffers) && $pendingOffers->isEmpty())
                                    <div class="p-6 text-center">
                                        <div class="flex flex-col items-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900">Aucune offre en attente</h3>
                                            <p class="mt-1 text-sm">Toutes les offres soumises ont été traitées.</p>
                                        </div>
                                    </div>
                                @elseif(isset($pendingOffers) && count($pendingOffers) > 0)
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($pendingOffers->take(5) as $offer)
                                        <li class="px-6 py-4 hover:bg-gray-50">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                                <div class="mb-4 sm:mb-0 flex-grow min-w-0">
                                                    <div class="flex items-center">
                                                        <div class="bg-yellow-100 p-2 rounded-full mr-3 sm:mr-4 flex-shrink-0">
                                                            <i class="fas fa-hourglass-half text-yellow-600"></i>
                                                        </div>
                                                        <div class="flex-grow min-w-0">
                                                            <p class="text-sm font-medium text-purple-700 hover:text-purple-900 truncate" title="{{ $offer->title }}">{{ $offer->title }}</p>
                                                            <p class="text-xs text-gray-500">
                                                                Soumis par: <span class="font-medium">{{ $offer->user->name ?? 'N/A' }}</span> • {{ $offer->created_at->diffForHumans() }}
                                                            </p>
                                                            <div class="mt-1 flex flex-wrap gap-1 sm:gap-2">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                    {{ $offer->type }}
                                                                </span>
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                    {{ $offer->sector }}
                                                                </span>
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                                    {{ $offer->region }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex flex-shrink-0 flex-wrap justify-end gap-2 mt-3 sm:mt-0 sm:ml-4">
                                                    <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs sm:text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" onclick="toggleDetails('dashboard-offer-details-{{ $offer->id }}')">
                                                        <i class="fas fa-eye mr-1 sm:mr-2"></i> Détails
                                                    </button>
                                                    
                                                    <a href="{{ route('admin.offers.edit', $offer->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs sm:text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <i class="fas fa-edit mr-1 sm:mr-2"></i> Modifier
                                                    </a>
                                                    
                                                    <form action="{{ route('admin.offers.validate', $offer->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs sm:text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                                            <i class="fas fa-check mr-1 sm:mr-2"></i> Valider
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('admin.offers.reject', $offer->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs sm:text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                            <i class="fas fa-times mr-1 sm:mr-2"></i> Rejeter
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <div id="dashboard-offer-details-{{ $offer->id }}" class="mt-4 hidden">
                                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                                    <h4 class="text-md font-semibold text-gray-800 mb-2">Description de l'offre</h4>
                                                    <p class="text-sm text-gray-700 mb-3 leading-relaxed">{{ $offer->description }}</p>
                                                    
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                                        <div><strong class="text-gray-600">Budget:</strong> {{ number_format($offer->budget ?? 0, 0, ',', ' ') }} FCFA</div>
                                                        <div><strong class="text-gray-600">Date limite:</strong> {{ $offer->deadline ? \Carbon\Carbon::parse($offer->deadline)->format('d/m/Y') : 'N/A' }}</div>
                                                        <div><strong class="text-gray-600">Durée:</strong> {{ $offer->duration ?? 'Non spécifiée' }}</div>
                                                        <div class="md:col-span-2"><strong class="text-gray-600">Compétences:</strong> {{ $offer->required_skills ?? 'N/A' }}</div>
                                                        <div><strong class="text-gray-600">Entreprise:</strong> {{ $offer->company_name ?? $offer->company ?? 'N/A' }}</div>
                                                        <div><strong class="text-gray-600">Email:</strong> {{ $offer->email ?? 'N/A' }}</div>
                                                        <div><strong class="text-gray-600">Téléphone:</strong> {{ $offer->phone ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @if(isset($pendingOffers) && $pendingOffers->count() > 5)
                                    <div class="px-6 py-3 bg-gray-50 text-right border-t border-gray-200">
                                        <a href="{{ route('admin.offers.pending') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                            Voir toutes les {{ $pendingOffers->count() }} offres en attente <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                    @endif
                                @else
                                     <div class="p-6 text-center text-gray-500">
                                        Aucune offre en attente pour le moment.
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Fin Section Offres en Attente -->
                     <template x-if="currentTab === 'activeOffers'">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Offres Actives</h3>
                                <p class="mt-1 text-sm text-gray-500">Liste de toutes les offres actuellement publiées.</p>
                            </div>

                            @if(session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 my-3">
                                {{ session('success') }}
                            </div>
                            @endif

                            <ul class="divide-y divide-gray-200">
                                @if(isset($activeOffers) && $activeOffers->count() > 0)
                                    @foreach($activeOffers as $offer)
                                    <li class="px-6 py-4 hover:bg-gray-50">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                            <div class="mb-3 sm:mb-0">
                                                <div class="flex items-center">
                                                    <div class="bg-green-100 p-2 rounded-full mr-4 flex-shrink-0">
                                                        <i class="fas fa-check-circle text-green-600"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $offer->title }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            Publié par: {{ $offer->user->name ?? 'Utilisateur inconnu' }} • {{ $offer->created_at->diffForHumans() }}
                                                        </p>
                                                        <div class="mt-1 flex flex-wrap gap-1">
                                                            @if($offer->type)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $offer->type }}
                                                            </span>
                                                            @endif
                                                            @if($offer->sector)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                {{ $offer->sector }}
                                                            </span>
                                                            @endif
                                                            @if($offer->region)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                {{ $offer->region }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleDetails('active-offer-details-{{ $offer->id }}')">
                                                    <i class="fas fa-eye mr-1"></i> Détails
                                                </button>
                                                <form action="{{ route('admin.offers.delete', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre active ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div id="active-offer-details-{{ $offer->id }}" class="mt-4 hidden">
                                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                                <h4 class="text-md font-semibold text-gray-800 mb-2">Description de l'offre</h4>
                                                <p class="text-sm text-gray-700 mb-3">{{ $offer->description }}</p>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                                    <div><strong class="text-gray-600">Budget:</strong> {{ number_format($offer->budget ?? 0, 0, ',', ' ') }} FCFA</div>
                                                    <div><strong class="text-gray-600">Date limite:</strong> {{ $offer->deadline ? \Carbon\Carbon::parse($offer->deadline)->format('d/m/Y') : 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Durée:</strong> {{ $offer->duration ?? 'Non spécifiée' }}</div>
                                                    <div class="md:col-span-2"><strong class="text-gray-600">Compétences:</strong> {{ $offer->required_skills ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Entreprise:</strong> {{ $offer->company_name ?? $offer->company ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Email:</strong> {{ $offer->email ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Téléphone:</strong> {{ $offer->phone ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center text-gray-500">
                                            <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune offre active</h3>
                                            <p class="text-sm">Il n'y a actuellement aucune offre publiée.</p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </template>
                        <script>
                            // Fonction pour basculer la visibilité des détails d'offre
                            window.toggleDetails = function(id) {
                                const element = document.getElementById(id);
                                if (element) {
                                    element.classList.toggle('hidden');
                                }
                            };
                        </script>
                    </template>

                    <!-- Users Tab -->
                    <template x-if="currentTab === 'users'">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Liste des Utilisateurs</h3>
            <div class="relative">
                <input type="text" placeholder="Rechercher..." class="pl-10 pr-4 py-2 border rounded-md text-sm">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
        
        @if(isset($users) && $users->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Inscription</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->role ?? 'Utilisateur' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <!-- Bouton Modifier -->
                                <a href="#" @click="editUser({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                
                                <!-- Bouton Supprimer -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-6 text-center text-gray-500">
                Aucun utilisateur trouvé.
            </div>
        @endif
    </div>
</template>
                    <!-- Pending Offers Tab -->
                    <template x-if="currentTab === 'pendingOffers'">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Offres en Attente de Validation</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $pendingOffersCount ?? '0' }} offres nécessitent votre approbation</p>
                            </div>
                            
                            @if(session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 my-3">
                                {{ session('success') }}
                            </div>
                            @endif
                            
                            <ul class="divide-y divide-gray-200">
                                @if(isset($pendingOffers) && $pendingOffers->count() > 0)
                                    @foreach($pendingOffers as $offer)
                                    <li class="px-6 py-4 hover:bg-gray-50">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                            <div class="mb-3 sm:mb-0">
                                                <div class="flex items-center">
                                                    <div class="bg-yellow-100 p-2 rounded-full mr-4 flex-shrink-0">
                                                        <i class="fas fa-hourglass-half text-yellow-600"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $offer->title }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            Soumis par: {{ $offer->user->name ?? 'Utilisateur inconnu' }} • {{ $offer->created_at->diffForHumans() }}
                                                        </p>
                                                        <div class="mt-1 flex flex-wrap gap-1">
                                                            @if($offer->type)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $offer->type }}
                                                            </span>
                                                            @endif
                                                            @if($offer->sector)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                {{ $offer->sector }}
                                                            </span>
                                                            @endif
                                                            @if($offer->region)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                {{ $offer->region }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleDetails('dashboard-pending-{{ $offer->id }}')">
                                                    <i class="fas fa-eye mr-1"></i> Détails
                                                </button>
                                                
                                                <a href="{{ route('admin.offers.edit', $offer->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <i class="fas fa-edit mr-1"></i> Modifier
                                                </a>
                                                
                                                <form action="{{ route('admin.offers.validate', $offer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                                        <i class="fas fa-check mr-1"></i> Valider
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('admin.offers.reject', $offer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                                        <i class="fas fa-times mr-1"></i> Rejeter
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <!-- Détails de l'offre (initialement masqués) -->
                                        <div id="dashboard-pending-{{ $offer->id }}" class="mt-4 hidden">
                                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                                <h4 class="text-md font-semibold text-gray-800 mb-2">Description de l'offre</h4>
                                                <p class="text-sm text-gray-700 mb-3">{{ $offer->description }}</p>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                                    <div><strong class="text-gray-600">Budget:</strong> {{ number_format($offer->budget ?? 0, 0, ',', ' ') }} FCFA</div>
                                                    <div><strong class="text-gray-600">Date limite:</strong> {{ $offer->deadline ? \Carbon\Carbon::parse($offer->deadline)->format('d/m/Y') : 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Durée:</strong> {{ $offer->duration ?? 'Non spécifiée' }}</div>
                                                    <div class="md:col-span-2"><strong class="text-gray-600">Compétences:</strong> {{ $offer->required_skills ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Entreprise:</strong> {{ $offer->company_name ?? $offer->company ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Email:</strong> {{ $offer->email ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Téléphone:</strong> {{ $offer->phone ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center text-gray-500">
                                            <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune offre en attente</h3>
                                            <p class="text-sm">Toutes les offres soumises ont été traitées.</p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                            
                            @if(isset($pendingOffers) && $pendingOffers->count() > 5)
                            <div class="px-6 py-3 bg-gray-50 text-right border-t border-gray-200">
                                <a href="{{ route('admin.offers.pending') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                    Voir toutes les {{ $pendingOffers->count() }} offres en attente <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </template>
                    
                    <!-- Active Offers Tab -->
                    <template x-if="currentTab === 'activeOffers'">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Offres Actives Publiées</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $activeOffersCount ?? '0' }} offres actuellement publiées</p>
                            </div>
                            
                            @if(session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 my-3">
                                {{ session('success') }}
                            </div>
                            @endif
                            
                            <ul class="divide-y divide-gray-200">
                                @if(isset($activeOffers) && $activeOffers->count() > 0)
                                    @foreach($activeOffers as $offer)
                                    <li class="px-6 py-4 hover:bg-gray-50">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                            <div class="mb-3 sm:mb-0">
                                                <div class="flex items-center">
                                                    <div class="bg-green-100 p-2 rounded-full mr-4 flex-shrink-0">
                                                        <i class="fas fa-check-circle text-green-600"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $offer->title }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            Publié par: {{ $offer->user->name ?? 'Utilisateur inconnu' }} • {{ $offer->created_at->diffForHumans() }}
                                                        </p>
                                                        <div class="mt-1 flex flex-wrap gap-1">
                                                            @if($offer->type)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $offer->type }}
                                                            </span>
                                                            @endif
                                                            @if($offer->sector)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                {{ $offer->sector }}
                                                            </span>
                                                            @endif
                                                            @if($offer->region)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                {{ $offer->region }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleDetails('active-offer-details-{{ $offer->id }}')">
                                                    <i class="fas fa-eye mr-1"></i> Détails
                                                </button>
                                                
                                                <a href="{{ route('admin.offers.edit', $offer->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <i class="fas fa-edit mr-1"></i> Modifier
                                                </a>
                                                
                                                <form action="{{ route('admin.offers.delete', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <!-- Détails de l'offre (initialement masqués) -->
                                        <div id="active-offer-details-{{ $offer->id }}" class="mt-4 hidden">
                                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                                <h4 class="text-md font-semibold text-gray-800 mb-2">Description de l'offre</h4>
                                                <p class="text-sm text-gray-700 mb-3">{{ $offer->description }}</p>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                                    <div><strong class="text-gray-600">Budget:</strong> {{ number_format($offer->budget ?? 0, 0, ',', ' ') }} FCFA</div>
                                                    <div><strong class="text-gray-600">Date limite:</strong> {{ $offer->deadline ? \Carbon\Carbon::parse($offer->deadline)->format('d/m/Y') : 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Durée:</strong> {{ $offer->duration ?? 'Non spécifiée' }}</div>
                                                    <div class="md:col-span-2"><strong class="text-gray-600">Compétences:</strong> {{ $offer->required_skills ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Entreprise:</strong> {{ $offer->company_name ?? $offer->company ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Email:</strong> {{ $offer->email ?? 'N/A' }}</div>
                                                    <div><strong class="text-gray-600">Téléphone:</strong> {{ $offer->phone ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center text-gray-500">
                                            <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune offre active</h3>
                                            <p class="text-sm">Il n'y a actuellement aucune offre publiée.</p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                            
                            @if(isset($activeOffers) && $activeOffers->count() > 5)
                            <div class="px-6 py-3 bg-gray-50 text-right border-t border-gray-200">
                                <a href="{{ route('admin.offers.active') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                    Voir toutes les {{ $activeOffers->count() }} offres actives <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Dernières candidatures reçues -->
                        <div class="mt-8 bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <div class="flex flex-wrap items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-800">Candidatures récentes</h2>
                                    <a href="{{ route('admin.applications.index') }}" class="mt-2 sm:mt-0 text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                        Voir toutes <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                            
                            @if(isset($recentApplications) && $recentApplications->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Offre</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($recentApplications as $application)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $application->user ? $application->user->name : 'Utilisateur supprimé' }}</div>
                                                        <div class="text-xs text-gray-500">{{ $application->phone }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $application->offer->title ?? 'N/A' }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-500">{{ $application->created_at->format('d/m/Y H:i') }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $statusColors = [
                                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                                'accepted' => 'bg-green-100 text-green-800',
                                                                'rejected' => 'bg-red-100 text-red-800'
                                                            ];
                                                            $statusText = [
                                                                'pending' => 'En attente',
                                                                'accepted' => 'Acceptée',
                                                                'rejected' => 'Refusée'
                                                            ];
                                                        @endphp
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$application->status] }}">
                                                            {{ $statusText[$application->status] }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('admin.applications.show', $application->id) }}" class="text-indigo-600 hover:text-indigo-900">Détails</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center text-gray-500">
                                        <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune candidature récente</h3>
                                        <p class="text-sm">Vous n'avez pas encore reçu de candidatures.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </template>

                    <!-- Other tabs would follow the same pattern -->
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine JS Controller -->
   <script>
        function adminApp() {
            return {
                currentTab: 'dashboard',
                mobileMenuOpen: false,
                getTabTitle(tab) {
                    const titles = {
                        'dashboard': 'Tableau de Bord',
                        'users': 'Gestion Utilisateurs',
                        'pendingOffers': 'Offres en Attente',
                        'applications': 'Candidatures',
                        // Add other tab titles
                        // Add other tab titles if any
                    };
                    return titles[tab] || 'Tableau de Bord';
                },
                // Mettre à jour la fonction editUser ici
                editUser(userId) {
                    // Utiliser la bonne méthode pour générer l'URL avec le paramètre user
                    // La fonction route() de Laravel doit recevoir le paramètre nécessaire
                    window.location.href = `{{ route('admin.users.edit', ['user' => 'TEMP_USER_ID']) }}`.replace('TEMP_USER_ID', userId);
                },
            };
        }
        
        // Fonction globale pour basculer l'affichage des détails
        window.toggleDetails = function(id) {
            const element = document.getElementById(id);
            if (element) {
                element.classList.toggle('hidden');
                console.log('Toggle ' + id + ': ' + !element.classList.contains('hidden'));
            } else {
                console.error('Élément non trouvé: ' + id);
            }
        };
    </script>
</body>
</html>