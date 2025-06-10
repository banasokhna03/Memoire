<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Candidatures - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #6b21a8 0%, #4c1d95 100%);
        }
        .application-card {
            transition: all 0.3s ease;
        }
        .application-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #8b5cf6;
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
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                </button>
            </form>
        </div>
        
        <!-- Menu mobile -->
        <button class="md:hidden text-purple-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </nav>

    <!-- Contenu principal -->
    <main class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Titre et description -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-purple-900 mb-2">Mes Candidatures</h1>
            <p class="text-gray-600 max-w-3xl">Suivez l'évolution de vos candidatures aux appels d'offres et restez informé de leur statut.</p>
        </div>

        <!-- Liste des candidatures -->
        @if($applications->isEmpty())
            <div class="bg-white rounded-xl shadow-md p-10 text-center">
                <div class="inline-block bg-purple-100 rounded-full p-4 mb-4">
                    <i class="fas fa-folder-open text-3xl text-purple-500"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Vous n'avez encore soumis aucune candidature</h2>
                <p class="text-gray-600 max-w-lg mx-auto mb-6">Explorez les offres disponibles et postulez pour trouver votre prochaine opportunité professionnelle.</p>
                <a href="{{ url('/') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-search mr-2"></i> Découvrir les offres
                </a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($applications as $application)
                    <div class="application-card bg-white p-6 rounded-xl shadow-sm border-l-4 border-transparent">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div>
                                <h3 class="text-xl font-bold text-purple-900 mb-1">{{ $application->offer->title }}</h3>
                                <p class="text-gray-700 mb-2">{{ $application->offer->company }}</p>
                                
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    <span>Candidature soumise le {{ $application->created_at->format('d/m/Y') }}</span>
                                </div>
                                
                                <div class="flex flex-wrap gap-3">
                                    @if($application->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full flex items-center">
                                            <i class="fas fa-clock mr-1"></i> En attente
                                        </span>
                                    @elseif($application->status == 'accepted')
                                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Acceptée
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full flex items-center">
                                            <i class="fas fa-times-circle mr-1"></i> Refusée
                                        </span>
                                    @endif
                                    
                                    <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full">
                                        {{ $application->offer->type }}
                                    </span>
                                    
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                        {{ $application->offer->sector }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row md:flex-col gap-2">
                                <a href="{{ route('offers.show', $application->offer_id) }}" class="bg-white hover:bg-gray-50 text-purple-700 border border-purple-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap flex items-center justify-center">
                                    <i class="fas fa-eye mr-1"></i> Voir l'offre
                                </a>
                                
                                @if($application->cv_path)
                                <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap flex items-center justify-center">
                                    <i class="fas fa-file-alt mr-1"></i> Voir mon CV
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-purple-900 text-white pt-6 pb-4 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-purple-800 mt-4 pt-4 text-center text-purple-300 text-sm">
                <p>© 2023 AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>
