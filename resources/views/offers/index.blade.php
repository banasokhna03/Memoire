<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres disponibles - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .offer-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
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
    </style>
</head>
<body class="bg-gray-50 text-purple-900 font-sans">

    <!-- Nouveau Header (topbar) -->
    <nav class="bg-white shadow-lg py-3 px-6 flex justify-between items-center sticky top-0 z-50">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            <span class="text-xl font-bold text-green-600">AppelOffres<span class="text-purple-700">SN</span></span>
        </div>

        <!-- Boutons -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ url('/publish-offer') }}" class="text-purple-700 hover:text-purple-900 text-white font-semibold px-5 py-2 rounded-full transition-all flex items-center pulse-hover">
                <i class="fas fa-bullhorn mr-2"></i> Publier une Offre
            </a>
            <a href="{{ url('/archive') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
                <i class="fas fa-search mr-2"></i> Parcourir
            </a>
            <a href="{{ url('/login') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Connexion
            </a>
            <a href="{{ route('admin.dashboard') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
    <i class="fas fa-user-shield mr-2"></i> Admin
     </a>

        </div>
        
        <!-- Menu mobile -->
        <button class="md:hidden text-purple-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </nav>

    <!-- Banner avec recherche -->
    <header class="relative bg-cover bg-center h-80" style="background-image: url('{{ asset('images/r.png') }}'); background-position: center 70%;">
     <div class="absolute inset-0 bg-black opacity-40"></div>
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
        <div class="animate__animated animate__fadeIn">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
                TROUVEZ LES MEILLEURES OFFRES AU SÉNÉGAL
            </h1>
            <p class="text-white text-lg md:text-xl mb-6 max-w-2xl mx-auto">
                Accédez aux appels d'offres publics et privés en quelques clics
            </p>
            <center>
                <form class="w-full max-w-3xl bg-white rounded-full search-box animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="flex flex-col md:flex-row">
                        <div class="flex-1 flex items-center px-6 py-4">
                            <i class="fas fa-search text-purple-500 mr-3"></i>
                            <input type="text" placeholder="Mots-clés, secteurs..." class="w-full outline-none text-gray-700 placeholder-gray-400">
                        </div>
                        <div class="flex-1 flex items-center px-6 py-4 border-t md:border-t-0 md:border-l border-gray-200">
                            <i class="fas fa-map-marker-alt text-purple-500 mr-3"></i>
                            <input type="text" placeholder="Localisation, région..." class="w-full outline-none text-gray-700 placeholder-gray-400">
                        </div>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-4 rounded-r-full font-semibold transition-colors">
    <i class="fas fa-search mr-2"></i> Rechercher
</button>

                    </div>
                </form>
            </center>
        </div>
    </div>
</header>


    <!-- Contenu principal -->
    <main class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filtres (sidebar) -->
            <aside class="md:w-1/4">
                <div class="bg-white p-6 rounded-xl shadow-md sticky top-24">
                    <h3 class="font-bold text-lg text-purple-800 mb-4 flex items-center">
                        <i class="fas fa-filter mr-2 text-purple-600"></i> Filtres
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type d'offre</label>
                            <select class="w-full rounded-lg border-gray-300 text-purple-800 focus:ring-purple-500 focus:border-purple-500">
                                <option>Tous types</option>
                                <option>Public</option>
                                <option>Privé</option>
                                <option>International</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Secteur d'activité</label>
                            <select class="w-full rounded-lg border-gray-300 text-purple-800 focus:ring-purple-500 focus:border-purple-500">
                                <option>Tous secteurs</option>
                                <option>BTP</option>
                                <option>Informatique</option>
                                <option>Santé</option>
                                <option>Éducation</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date limite</label>
                            <select class="w-full rounded-lg border-gray-300 text-purple-800 focus:ring-purple-500 focus:border-purple-500">
                                <option>Toutes dates</option>
                                <option>Cette semaine</option>
                                <option>Ce mois</option>
                                <option>Prochains 3 mois</option>
                            </select>
                        </div>
                        
                        <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg transition-colors">
                            Appliquer les filtres
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Liste des offres -->
            <div class="md:w-3/4">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-purple-900 flex items-center">
                        <i class="fas fa-bullseye mr-3 text-purple-600"></i> Offres Disponibles
                    </h1>
                    <p class="text-purple-600 bg-purple-100 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $offers->count() }} offres trouvées
                    </p>
                </div>

                @auth
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-6 rounded-xl shadow-inner mb-8 animate__animated animate__fadeIn">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-lg text-purple-800 mb-2">Votre espace membre</h3>
                            <p class="text-purple-700 text-sm">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i> Accès complet aux offres et fonctionnalités premium
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <form method="POST" action="{{ url('/subscribe') }}">
                                @csrf
                                <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-full transition-all flex items-center whitespace-nowrap">
                                    <i class="fas fa-crown mr-2"></i> S'abonner
                                </button>
                            </form>
                            <a href="{{ url('/my-saved-offers') }}" class="bg-white hover:bg-gray-100 text-purple-700 font-semibold py-2 px-6 rounded-full border border-purple-200 transition-all flex items-center justify-center whitespace-nowrap">
                                <i class="fas fa-bookmark mr-2 text-purple-600"></i> Mes favoris
                            </a>
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
                        <h3 class="text-xl font-medium text-gray-600 mb-2">Aucune offre disponible actuellement</h3>
                        <p class="text-gray-500 max-w-md mx-auto">Nous n'avons trouvé aucune offre correspondant à vos critères. Essayez de modifier vos filtres ou revenez plus tard.</p>
                    </div>
                @else
                    <div class="grid gap-6">
                        @foreach($offers as $offer)
                            <div class="offer-card bg-white p-6 rounded-xl shadow-sm relative">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-start">
                                            <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                                <i class="fas fa-file-contract text-purple-600 text-xl"></i>
                                            </div>
                                            <div>
                                                <h2 class="text-xl font-bold text-purple-900 mb-1">{{ $offer->title }}</h2>
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
                                                <p class="text-gray-700 line-clamp-2">{{ $offer->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row md:flex-col gap-2">
                                        @auth
                                            <form method="POST" action="{{ url('/save-offer/' . $offer->id) }}">
                                                @csrf
                                                <button type="submit" class="bg-white hover:bg-purple-50 text-purple-700 border border-purple-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
                                                    <i class="far fa-bookmark mr-1"></i> Enregistrer
                                                </button>
                                            </form>
                                        @endauth
                                        <a href="{{ route('offers.show', $offer->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium text-center transition-colors whitespace-nowrap">
                                            <i class="fas fa-eye mr-1"></i> Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-10 flex justify-center">
                        <nav class="flex items-center space-x-2">
                            <a href="#" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#" class="px-3 py-1 rounded-lg bg-purple-600 text-white font-medium">1</a>
                            <a href="#" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                            <a href="#" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                            <span class="px-3 py-1 text-gray-500">...</span>
                            <a href="#" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">10</a>
                            <a href="#" class="px-3 py-1 rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                @endif

                
            </div>
        </div>
    </main>

    <!-- Footer -->
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
        // Animation au scroll
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