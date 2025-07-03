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
    </style>
</head>
<body class="bg-gray-50 text-purple-900 font-sans">

    <!-- Header -->
    <nav class="bg-white shadow-lg py-3 px-6 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-2">
<a href="{{ url('/') }}" class="flex items-center space-x-2">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
    <span class="text-xl font-bold text-green-600">AppelOffres<span class="text-purple-700">SN</span></span>
</a>        </div>
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ url('/publish-offer') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-2 rounded-full transition-all flex items-center pulse-hover">
                <i class="fas fa-bullhorn mr-2"></i> Publier une Offre
            </a>
            <a href="{{ route('offers.archive') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
        <i class="fas fa-search mr-2"></i> Parcourir offres
          </a>
           <div class="flex items-center relative"> <div>
                        <label for="auth-select" class="block text-sm font-medium text-gray-700 sr-only">S'identifier</label>

                        <select name="auth_action" id="auth-select"
                                class="w-auto px-4 py-2 rounded-lg border border-gray-300 input-highlight focus:outline-none text-gray-800
                                       absolute inset-0 opacity-0 cursor-pointer z-10">
                            <option value="" disabled selected class="default-auth-option">S'identifier</option>

                            @auth
                                <option value="{{ route('logout') }}" class="logout-option">Se déconnecter</option>
                            @else
                                <option value="{{ route('login') }}" class="login-option">Se connecter</option>
                                @if (Route::has('register'))
                                    <option value="{{ route('register') }}" class="register-option">S'inscrire</option>
                                @endif
                            @endauth
                        </select>

                        <div id="auth-display-button"
 class="w-auto px-5 py-2 rounded-full input-highlight focus:outline-none text-white font-semibold text-center cursor-pointer"
                             style="background-color:rgba(255, 255, 255, 0.68);">
                             <p style="color:rgb(121, 71, 221);"> <i class="fas fa-user mr-2"></i>S'identifier </p>
                        </div>
                    </div>
        <!--    <a href="{{ route('admin.dashboard') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
                <i class="fas fa-user-shield mr-2"></i> Admin
            </a>-->
        </div>
        <button class="md:hidden text-purple-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
      @auth
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-purple-600 hover:text-red-800 font-semibold transition-colors">
      <i class="fas fa-power-off mr-2"></i> Déconnexion    
        </button>
    </form>
    @endauth
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>
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
                    <form method="GET" action="{{ route('offers.index') }}" class="w-full max-w-3xl bg-white rounded-full search-box animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="flex flex-col md:flex-row">
                            <div class="flex-1 flex items-center px-6 py-4">
                                <i class="fas fa-search text-purple-500 mr-3"></i>
                                <input type="text" name="keywords" value="{{ request('keywords') }}" placeholder="Mots-clés, secteurs..." class="w-full outline-none text-gray-700 placeholder-gray-400">
                            </div>
                            <div class="flex-1 flex items-center px-6 py-4 border-t md:border-t-0 md:border-l border-gray-200">
                                <i class="fas fa-map-marker-alt text-purple-500 mr-3"></i>
                                <input type="text" name="region" value="{{ request('region') }}" placeholder="Localisation, région..." class="w-full outline-none text-gray-700 placeholder-gray-400">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg flex items-center justify-between animate__animated animate__fadeIn">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-green-600 text-xl mr-4"></i>
            <p class="text-green-800 font-medium">
                Pour découvrir toutes nos offres disponibles, cliquez sur ce bouton
            </p>
        </div>
        <a href="{{ route('offers.archive') }}" class="text-white font-semibold px-6 py-2 rounded-lg transition-all flex items-center" style="background-color:rgb(203, 100, 45); hover:background-color:rgb(203, 100, 45);">
            Voir toutes les offres
        </a>
    </div>
</div>
@if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-auto mt-4" role="alert" style="max-width: 768px;">
            <strong class="font-bold">Succès !</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                    <title>Fermer</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l3.029-2.651-3.029-2.651a1.2 1.2 0 1 1 1.697-1.697l2.651 3.029 2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-3.029 2.651 3.029 2.651a1.2 1.2 0 0 1 0 1.697z"/>
                </svg>
            </span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-auto mt-4" role="alert" style="max-width: 768px;">
            <strong class="font-bold">Erreur !</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                    <title>Fermer</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l3.029-2.651-3.029-2.651a1.2 1.2 0 1 1 1.697-1.697l2.651 3.029 2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-3.029 2.651 3.029 2.651a1.2 1.2 0 0 1 0 1.697z"/>
                </svg>
            </span>
        </div>
    @endif
<!-- Contenu principal -->
<main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filtres (sidebar élargie et décalée) -->
        <aside class="md:w-1/6 ml-4">
            <div class="bg-white p-5 rounded-xl shadow-md sticky top-24">
                <h3 class="font-bold text-lg text-purple-800 mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-purple-600"></i> Filtres
                </h3>
                <form id="filter-form" method="GET" action="{{ route('offers.index') }}">
                    <div class="space-y-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type d'offre</label>
                            <select id="type" name="type" class="w-full rounded-lg border-gray-300 text-purple-800 focus:ring-purple-500 focus:border-purple-500 text-sm">
                                <option value="Tous types" {{ request('type') == 'Tous types' ? 'selected' : '' }}>Tous types</option>
                                <option value="public" {{ request('type') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="prive" {{ request('type') == 'prive' ? 'selected' : '' }}>Privé</option>
                                <option value="international" {{ request('type') == 'international' ? 'selected' : '' }}>International</option>
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
                            <i class="fas fa-search mr-2"></i> Appliquer
                        </button>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Liste des offres (partie principale large) -->
        <div id="offres" class="md:w-5/6">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-purple-900 flex items-center">
                    <i class="fas fa-bullseye mr-3 text-purple-600"></i> Offres Disponibles
                </h1>
                <p class="text-purple-600 bg-purple-100 px-3 py-1 rounded-full text-sm font-medium">
                </p>
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
                    <h3 class="text-xl font-medium text-gray-600 mb-2">Aucune offre disponible actuellement</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Nous n'avons trouvé aucune offre correspondant à vos critères. Essayez de modifier vos filtres ou revenez plus tard.</p>
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
                <p>© {{ date('Y') }} AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Assurez-vous que ce script est inclus dans votre layout Blade, idéalement juste avant la balise </body>.

document.addEventListener('DOMContentLoaded', function() {
    // Logique pour le sélecteur d'authentification
    const authSelect = document.getElementById('auth-select');

    if (authSelect) {
        authSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const targetValue = selectedOption.value;

            // Si l'option sélectionnée est "logout_action", soumettez le formulaire de déconnexion.
            if (targetValue === 'logout_action') {
                // Assurez-vous que le formulaire avec l'ID 'logout-form' existe dans votre HTML
                const logoutForm = document.getElementById('logout-form');
                if (logoutForm) {
                    logoutForm.submit();
                } else {
                    console.error("Erreur: Le formulaire de déconnexion avec l'ID 'logout-form' n'a pas été trouvé.");
                }
            } else if (targetValue) {
                // Pour les autres options (login, register), redirigez simplement l'utilisateur.
                window.location.href = targetValue;
            }
        });

        // Optionnel : Réinitialiser le select à l'option par défaut après la sélection (si pas de redirection)
        // Utile si l'action ne quitte pas la page et que vous voulez que le "S'identifier" revienne.
        // authSelect.value = ''; // Remettre l'option par défaut 'S'identifier'
    }

    // Le code pour l'animation au scroll (Intersection Observer)
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

    // Le code pour l'animation fluide pour le défilement vers les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
    </script>
</body>
</html>