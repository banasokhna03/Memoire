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
    <nav class="bg-white shadow-lg py-3 px-6 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            <span class="text-xl font-bold text-green-600">AppelOffres<span class="text-purple-700">SN</span></span>
        </div>

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
        
        <button class="md:hidden text-purple-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </nav>

    <main class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-purple-900 mb-8 text-center">Mes Candidatures</h1>

        @if($applications->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-600">
                <p class="text-lg mb-4">Vous n'avez pas encore postulé à des offres.</p>
                <p>Parcourez nos <a href="{{ url('/archive') }}" class="text-purple-600 hover:underline font-medium">offres d'emploi</a> pour trouver celle qui vous convient !</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($applications as $application)
                    <div class="application-card bg-white p-6 rounded-xl shadow-sm border-l-4 border-transparent">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div>
                                {{-- Correction ici : Vérifier si $application->offer existe --}}
                                @if($application->offer)
                                    <h3 class="text-xl font-bold text-purple-900 mb-1">{{ $application->offer->title }}</h3>
                                    <p class="text-gray-700 mb-2">{{ $application->offer->company }}</p>
                                @else
                                    <h3 class="text-xl font-bold text-gray-500 mb-1">Offre (supprimée ou introuvable)</h3>
                                    <p class="text-gray-500 mb-2">Cette candidature est liée à une offre qui n'est plus disponible.</p>
                                @endif
                                <p class="text-gray-600 text-sm">Appliqué le {{ $application->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="flex flex-row md:flex-col gap-2">
                                {{-- Vérifier si $application->offer existe avant d'utiliser son ID dans le lien --}}
                                @if($application->offer)
                                    <a href="{{ route('offers.show', $application->offer_id) }}" class="bg-white hover:bg-gray-50 text-purple-700 border border-purple-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap flex items-center justify-center">
                                        <i class="fas fa-eye mr-1"></i> Voir l'offre
                                    </a>
                                @else
                                    {{-- Vous pouvez choisir de désactiver le bouton ou de le lier à une page d'erreur --}}
                                    <span class="bg-gray-200 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium opacity-75 cursor-not-allowed flex items-center justify-center">
                                        <i class="fas fa-eye mr-1"></i> Offre indisponible
                                    </span>
                                @endif
                                
                                @if($application->cv_path)
                                <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap flex items-center justify-center">
                                    <i class="fas fa-file-alt mr-1"></i> Voir mon doc
                                </a>
                                @endif
                                {{-- Vous pouvez ajouter un bouton pour voir la lettre de motivation si elle est stockée --}}
                                @if($application->cover_letter_path)
                                <a href="{{ asset('storage/' . $application->cover_letter_path) }}" target="_blank" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap flex items-center justify-center">
                                    <i class="fas fa-file-alt mr-1"></i> Voir ma lettre
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="bg-purple-900 text-white pt-6 pb-4 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-purple-800 mt-4 pt-4 text-center text-purple-300 text-sm">
                <p>© 2023 AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>