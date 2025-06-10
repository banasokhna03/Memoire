<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $offer->title }} - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #6b21a8 0%, #4c1d95 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg py-3 px-6 flex justify-between items-center sticky top-0 z-50">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            <span class="text-xl font-bold text-green-600">AppelOffres<span class="text-purple-700">SN</span></span>
        </div>

        <!-- Boutons -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ url('/') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
                <i class="fas fa-home mr-2"></i> Accueil
            </a>
            <a href="{{ url('/publish-offer') }}" class="text-purple-700 hover:text-purple-900 text-white font-semibold px-5 py-2 rounded-full transition-all flex items-center">
                <i class="fas fa-bullhorn mr-2"></i> Publier une Offre
            </a>
            <a href="{{ url('/login') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Connexion
            </a>
        </div>
        
        <!-- Menu mobile -->
        <button class="md:hidden text-purple-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </nav>

    <!-- Contenu principal -->
    <main class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Bouton retour -->
        <div class="mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center text-purple-700 hover:text-purple-900 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Retour aux offres
            </a>
        </div>

        <!-- Détails de l'offre -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- En-tête de l'offre -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-purple-900 mb-2">{{ $offer->title }}</h1>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
                                {{ $offer->type ?? 'Non spécifié' }}
                            </span>
                            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                {{ $offer->sector ?? 'Tous secteurs' }}
                            </span>
                            <span class="bg-amber-100 text-amber-800 text-sm px-3 py-1 rounded-full">
                                <i class="far fa-clock mr-1"></i> Date limite: {{ $offer->deadline ? $offer->deadline->format('d/m/Y') : 'Non spécifiée' }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="block text-gray-500 text-sm">Publié le {{ $offer->created_at->format('d/m/Y') }}</span>
                        @auth
                        <form method="POST" action="{{ url('/save-offer/' . $offer->id) }}" class="mt-2">
                            @csrf
                            <button type="submit" class="bg-white hover:bg-purple-50 text-purple-700 border border-purple-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="far fa-bookmark mr-1"></i> Enregistrer cette offre
                            </button>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Corps de l'offre -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Colonne principale avec description -->
                    <div class="md:col-span-2 space-y-8">
                        <div>
                            <h2 class="text-xl font-semibold text-purple-900 mb-4">Description de l'offre</h2>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($offer->description)) !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-purple-900 mb-4">Compétences requises</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $offer->required_skills) as $skill)
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Colonne latérale avec informations supplémentaires -->
                    <div class="space-y-6">
                        <!-- Détails de l'offre -->
                        <div class="bg-gray-50 p-5 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-900 mb-3">Détails de l'offre</h3>
                            <ul class="space-y-3">
                                @if($offer->budget)
                                <li class="flex items-start">
                                    <i class="fas fa-money-bill-wave text-purple-600 mt-1 mr-3"></i>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700">Budget</span>
                                        <span class="text-gray-900">{{ number_format($offer->budget, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                </li>
                                @endif
                                <li class="flex items-start">
                                    <i class="fas fa-calendar-alt text-purple-600 mt-1 mr-3"></i>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700">Durée du projet</span>
                                        <span class="text-gray-900">{{ $offer->duration ?? 'Non spécifiée' }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-purple-600 mt-1 mr-3"></i>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700">Localisation</span>
                                        <span class="text-gray-900">{{ $offer->region ?? 'Non spécifiée' }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Coordonnées de l'entreprise -->
                        <div class="bg-gray-50 p-5 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-900 mb-3">Contact</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-building text-purple-600 mt-1 mr-3"></i>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700">Entreprise</span>
                                        <span class="text-gray-900">{{ $offer->company }}</span>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-envelope text-purple-600 mt-1 mr-3"></i>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700">Email</span>
                                        <a href="mailto:{{ $offer->email }}" class="text-purple-700 hover:text-purple-900">{{ $offer->email }}</a>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-phone-alt text-purple-600 mt-1 mr-3"></i>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-700">Téléphone</span>
                                        <a href="tel:{{ $offer->phone }}" class="text-purple-700 hover:text-purple-900">{{ $offer->phone }}</a>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Bouton de candidature -->
                        <div class="text-center">
                            @auth
                                <a href="{{ route('applications.create', $offer->id) }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-paper-plane mr-2"></i> Postuler à cette offre
                                </a>
                                <p class="text-xs text-gray-500 mt-2">Soumettez votre CV et lettre de motivation</p>
                            @else
                                <a href="{{ route('login') }}?redirect_to={{ route('applications.create', $offer->id) }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Connectez-vous pour postuler
                                </a>
                                <p class="text-xs text-gray-500 mt-2">Ou contactez directement par email : <a href="mailto:{{ $offer->email }}?subject=Candidature pour: {{ $offer->title }}" class="text-purple-600 hover:underline">{{ $offer->email }}</a></p>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Autres offres similaires (optionnel) -->
        <div class="mt-12">
            <h2 class="text-xl font-bold text-purple-900 mb-6">Offres similaires</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Cette section pourrait être remplie dynamiquement avec des offres similaires -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-5">
                    <p class="text-sm text-gray-500">Cette fonctionnalité sera bientôt disponible</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-purple-900 text-white pt-12 pb-6 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-purple-800 mt-8 pt-6 text-center text-purple-300 text-sm">
                <p>© 2023 AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>