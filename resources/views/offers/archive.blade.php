<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toutes les Offres - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles personnalisés copiés de votre page d'index */
        .offer-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            max-width: 100%;
        }
        .offer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #8b5cf6;
        }
        .pulse-hover:hover {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #6b21a8 0%, #4c1d95 100%);
        }
        .search-box {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }
        .offer-content {
            flex: 1;
            min-width: 0;
        }
        .offer-title {
            font-size: 1.1rem;
            line-height: 1.3;
        }
        .offer-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
            font-size: 0.95rem;
        }
        .scroll-message {
            background: linear-gradient(90deg, rgba(139,92,246,0.1) 0%, rgba(124,58,237,0.1) 100%);
            border-left: 4px solid #8b5cf6;
        }

        /* --- Styles pour le pied de page fixe --- */
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto; /* Permet au contenu principal de grandir et de pousser le pied de page */
        }
        /* --- Fin des styles pour le pied de page fixe --- */
    </style>
</head>
<body class="bg-gray-50 text-purple-900 font-sans">

    <nav class="bg-white shadow-lg py-3 px-6 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-2">
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
    <span class="text-xl font-bold text-green-600">AppelOffres<span class="text-purple-700">SN</span></span>
</a>
        </div>
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ url('/publish-offer') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-2 rounded-full transition-all flex items-center pulse-hover">
                <i class="fas fa-bullhorn mr-2"></i> Publier une Offre
            </a>
            <a href="{{ route('offers.archive') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
                <i class="fas fa-search mr-2"></i> Parcourir
            </a>
           @auth
           <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-purple-600 hover:text-red-800 font-semibold transition-colors">
      <i class="fas fa-power-off mr-2"></i> Déconnexion    
        </button>
    </form>
      @endauth
</div>
        <button class="md:hidden text-purple-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8">
            <aside class="md:w-1/6 ml-4">
                <div class="bg-white p-5 rounded-xl shadow-md sticky top-24">
                    <h3 class="font-bold text-lg text-purple-800 mb-4 flex items-center">
                        <i class="fas fa-filter mr-2 text-purple-600"></i> Filtres
                    </h3>
                    <form id="filter-form" method="GET" action="{{ route('offers.archive') }}"> {{-- Ajout de l'action et méthode --}}
                        <div class="space-y-4">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type d'offre</label>
                                <select id="type" name="type" class="w-full rounded-lg border-gray-300 text-purple-800 focus:ring-purple-500 focus:border-purple-500 text-sm">
                                    <option value="Tous types" {{ request('type') == 'Tous types' ? 'selected' : '' }}>Tous types</option>
                                    <option value="Public" {{ request('type') == 'Public' ? 'selected' : '' }}>Public</option>
                                    <option value="Privé" {{ request('type') == 'Privé' ? 'selected' : '' }}>Privé</option>
                                    <option value="International" {{ request('type') == 'International' ? 'selected' : '' }}>International</option>
                                </select>
                            </div>
                            <div>
                                <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Secteur d'activité</label>
                                <select id="sector" name="sector" class="w-full rounded-lg border-gray-300 text-purple-800 focus:ring-purple-500 focus:border-purple-500 text-sm">
                                    <option value="Tous secteurs" {{ request('sector') == 'Tous secteurs' ? 'selected' : '' }}>Tous secteurs</option>
                                    @foreach($activitySectors as $sector)
                                        <option value="{{ $sector->id }}" {{ request('sector') == $sector->id ? 'selected' : '' }}>{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Date limite</label>
                                <select id="deadline" name="deadline" class="w-full rounded-lg border-gray-300 text-purple-800 focus:ring-purple-500 focus:border-purple-500 text-sm">
                                    <option value="Toutes dates" {{ request('deadline') == 'Toutes dates' ? 'selected' : '' }}>Toutes dates</option>
                                    <option value="Cette semaine" {{ request('deadline') == 'Cette semaine' ? 'selected' : '' }}>Cette semaine</option>
                                    <option value="Ce mois" {{ request('deadline') == 'Ce mois' ? 'selected' : '' }}>Ce mois</option>
                                    <option value="Prochains 3 mois" {{ request('deadline') == 'Prochains 3 mois' ? 'selected' : '' }}>Prochains 3 mois</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg transition-colors text-sm">
                                Appliquer
                            </button>
                            <button type="button" onclick="resetFilters()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg transition-colors text-sm">
                                Réinitialiser
                            </button>
                        </div>
                    </form>
                </div>
            </aside>

            <div id="offres" class="md:w-5/6">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-purple-900 flex items-center">
                        <i class="fas fa-archive mr-3 text-purple-600"></i> Archives des Offres
                    </h1>
                    <div class="flex items-center space-x-4">
                        <p class="text-purple-600 bg-purple-100 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $offers->total() }} offres archivées
                        </p>
                        <div class="relative">
                            <label for="sort-by" class="sr-only">Trier par</label>
                            <select id="sort-by" name="sort" class="block w-full rounded-lg border-gray-300 text-purple-800 focus:ring-purple-500 focus:border-purple-500 text-sm pl-3 pr-10 py-2">
                                <option value="recent" {{ request('sort') == 'recent' || !request('sort') ? 'selected' : '' }}>Plus récentes</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciennes</option>
                                <option value="deadline_asc" {{ request('sort') == 'deadline_asc' ? 'selected' : '' }}>Date limite (croissant)</option>
                                <option value="deadline_desc" {{ request('sort') == 'deadline_desc' ? 'selected' : '' }}>Date limite (décroissant)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                @auth
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-6 rounded-xl shadow-inner mb-8 animate__animated animate__fadeIn">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-lg text-purple-800 mb-2">Bienvenue, {{ Auth::user()->name }} </h3>
                        </div>
                    </div>
                </div>
                @endauth

                @guest
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-500 text-xl mt-1 mr-3"></i>
                        </div>
                        <div>
                            <p class="text-yellow-800">
                                <a href="{{ url('/login') }}" class="font-semibold underline hover:text-yellow-900">Connectez-vous</a> ou 
                                <a href="{{ url('/register') }}" class="font-semibold underline hover:text-yellow-900">inscrivez-vous</a> pour accéder à toutes les fonctionnalités : sauvegarde d'offres, alertes personnalisées et soumission en ligne.
                            </p>
                        </div>
                    </div>
                </div>
                @endguest

                @if($offers->isEmpty())
                    <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-600 mb-2">Aucune offre archivée disponible actuellement</h3>
                        <p class="text-gray-500 max-w-md mx-auto">Nous n'avons trouvé aucune offre dans les archives. Revenez plus tard ou contactez l'administrateur.</p>
                    </div>
                @else
                    <div class="grid gap-6">
                        @foreach($offers as $offer)
                            <div class="offer-card bg-white p-6 rounded-xl shadow-sm relative">
                                <div class="flex flex-col md:flex-row md:justify-between gap-4">
                                    <div class="flex items-start w-full">
                                        <div class="bg-purple-100 p-3 rounded-lg mr-4 flex-shrink-0">
                                            <i class="fas fa-file-contract text-purple-600 text-xl"></i>
                                        </div>
                                        <div class="offer-content flex-grow">
                                            <h2 class="offer-title font-bold text-purple-900 mb-1">{{ $offer->title }}</h2>
                                            <div class="flex flex-wrap gap-2 mb-3">
                                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">
                                                    {{ $offer->type ?? 'Non spécifié' }}
                                                </span>
                                                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                                    {{ $offer->sector ?? 'Tous secteurs' }}
                                                </span>
                                                <span class="bg-amber-100 text-amber-800 text-xs px-3 py-1 rounded-full">
                                                    <i class="far fa-clock mr-1"></i> {{ $offer->deadline ? $offer->deadline->format('d/m/Y') : 'Date limite non spécifiée' }}
                                                </span>
                                            </div>
                                            <p class="offer-description text-gray-700">{{ $offer->description }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-row md:flex-col gap-2 justify-end md:justify-start">
                                        @auth
                                            <form method="POST" action="{{ url('/save-offer/' . $offer->id) }}">
                                                @csrf
                                                <button type="submit" class="bg-white hover:bg-purple-50 text-purple-700 border border-purple-200 px-3 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
                                                    <i class="far fa-bookmark mr-1"></i> Enregistrer
                                                </button>
                                            </form>
                                        @endauth
                                        <a href="{{ route('offers.show', $offer->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg text-sm font-medium text-center transition-colors whitespace-nowrap">
                                            <i class="fas fa-eye mr-1"></i> Voir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-10 flex justify-center">
                        <nav class="flex items-center space-x-2">
                            {{ $offers->links('vendor.pagination.tailwind') }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <footer class="bg-purple-900 text-white pt-12 pb-6 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">AppelOffresSN</h3>
                    <p class="text-purple-200 text-sm">La plateforme de référence pour les appels d'offres au Sénégal, connectant entreprises et opportunités.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Ressources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-purple-200 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-purple-200 hover:text-white transition-colors">Guide de soumission</a></li>
                        <li><a href="#" class="text-purple-200 hover:text-white transition-colors">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-purple-200 hover:text-white transition-colors">Politique de confidentialité</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 text-purple-300"></i>
                            <span class="text-purple-200">Dakar, Sénégal</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-purple-300"></i>
                            <span class="text-purple-200">+221 33 123 45 67</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-purple-300"></i>
                            <span class="text-purple-200">contact@appeloffressn.sn</span>
                        </li>
                    </ul>
                    <div class="mt-4 flex space-x-4">
                        <a href="#" class="text-purple-200 hover:text-white transition-colors text-xl">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-purple-200 hover:text-white transition-colors text-xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-purple-200 hover:text-white transition-colors text-xl">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-purple-800 mt-8 pt-6 text-center text-purple-300 text-sm">
                <p>© 2023 AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Gestion des favoris (copié de votre page d'index)
        document.querySelectorAll('.save-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    const icon = this.querySelector('i');
                    if(data.saved) {
                        icon.classList.replace('far', 'fas');
                        icon.classList.add('text-purple-600');
                        this.innerHTML = '<i class="fas fa-bookmark text-purple-600 mr-1"></i> Enregistré';
                    } else {
                        icon.classList.replace('fas', 'far');
                        icon.classList.remove('text-purple-600');
                        this.innerHTML = '<i class="far fa-bookmark mr-1"></i> Enregistrer';
                    }
                });
            });
        });

        // Filtrage des offres - soumission normale du formulaire
        // Le formulaire se soumet automatiquement avec la méthode GET vers la bonne URL

        // Tri des offres
        document.getElementById('sort-by')?.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            // Important : assurez-vous que cette route correspond à votre route d'archives
            window.location.href = url.toString();
        });

        // Réinitialisation des filtres
        function resetFilters() {
            // Important : assurez-vous que cette route correspond à votre route d'archives
            window.location.href = '{{ route("offers.archive") }}'; 
        }

        // Animation au scroll (copié de votre page d'index)
        document.addEventListener('DOMContentLoaded', function() {
            const offerCards = document.querySelectorAll('.offer-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            offerCards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>
</html>