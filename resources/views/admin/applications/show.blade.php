<?php
$statusStyles = [
    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
    'accepted' => 'bg-green-100 text-green-800 border-green-200',
    'rejected' => 'bg-red-100 text-red-800 border-red-200'
];

$statusLabels = [
    'pending' => 'En attente',
    'accepted' => 'Acceptée',
    'rejected' => 'Refusée'
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails candidature - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .info-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .status-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            min-width: 200px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            z-index: 10;
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
            </a>
        </div>
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ route('admin.dashboard') }}" class="text-purple-700 font-medium hover:text-purple-900 transition-colors flex items-center">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
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
    </nav>

    <!-- Contenu principal -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-purple-900 flex items-center">
                <i class="fas fa-user-tie mr-3 text-purple-600"></i> Détails de la candidature
            </h1>
            <a href="{{ route('admin.applications.index') }}" class="text-purple-600 hover:text-purple-800 font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8 info-card">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $application->user ? $application->user->name : 'Utilisateur supprimé' }}</h2>
                    <p class="text-gray-500 text-sm mt-1">Soumise le {{ $application->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusStyles[$application->status] }}">
                        {{ $statusLabels[$application->status] }}
                    </span>
                    
                    <div class="relative">
                        <button onclick="toggleStatusMenu()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">
                            <i class="fas fa-edit mr-2"></i> Modifier
                        </button>
                        <div id="statusDropdown" class="status-dropdown-content mt-1">
                            <form method="POST" action="{{ route('admin.applications.update-status', $application->id) }}" class="p-2 hover:bg-yellow-50">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="w-full text-left text-yellow-800 flex items-center">
                                    <i class="fas fa-clock mr-2"></i> En attente
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.applications.update-status', $application->id) }}" class="p-2 hover:bg-green-50">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="w-full text-left text-green-800 flex items-center">
                                    <i class="fas fa-check mr-2"></i> Accepter
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.applications.update-status', $application->id) }}" class="p-2 hover:bg-red-50">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="w-full text-left text-red-800 flex items-center">
                                    <i class="fas fa-times mr-2"></i> Refuser
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Informations candidat -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-purple-800 mb-4 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-purple-600"></i> Informations candidat
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nom complet</p>
                            <p class="font-medium">{{ $application->user ? $application->user->name : 'Utilisateur supprimé' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $application->user ? $application->user->email : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Téléphone</p>
                            <p class="font-medium">{{ $application->phone ?? 'Non spécifié' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">CV</p>
                            <p class="font-medium">
                                @if($application->cv_path)
                                    <a href="{{ route('admin.applications.download-cv', $application->id) }}" class="text-purple-600 hover:text-purple-800 flex items-center">
                                        <i class="fas fa-file-pdf mr-2"></i> Télécharger le CV
                                    </a>
                                @else
                                    <span class="text-gray-400">Aucun CV fourni</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Offre concernée -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-purple-800 mb-4 flex items-center">
                        <i class="fas fa-briefcase mr-2 text-purple-600"></i> Offre concernée
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Titre de l'offre</p>
                            <p class="font-medium">{{ $application->offer->title ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Entreprise</p>
                            <p class="font-medium">{{ $application->offer->company_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date limite</p>
                            <p class="font-medium">
                                {{ $application->offer->deadline ? \Carbon\Carbon::parse($application->offer->deadline)->format('d/m/Y') : 'Non spécifiée' }}
                            </p>
                        </div>
                    </div>
                    @if($application->offer)
                        <a href="{{ route('offers.show', $application->offer->id) }}" target="_blank" class="text-purple-600 hover:text-purple-800 flex items-center">
                            <i class="fas fa-external-link-alt mr-2"></i> Voir l'offre complète
                        </a>
                    @endif
                </div>

                <!-- Lettre de motivation -->
                <div>
                    <h3 class="text-lg font-semibold text-purple-800 mb-4 flex items-center">
                        <i class="fas fa-envelope-open-text mr-2 text-purple-600"></i> Lettre de motivation
                    </h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="whitespace-pre-wrap">{{ $application->cover_letter }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-purple-900 text-white pt-12 pb-6 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-purple-800 mt-8 pt-6 text-center text-purple-300 text-sm">
                <p>© {{ date('Y') }} AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleStatusMenu() {
            var dropdown = document.getElementById("statusDropdown");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }
        
        // Fermer le menu si l'utilisateur clique en dehors
        window.onclick = function(event) {
            if (!event.target.matches('.btn-primary')) {
                var dropdowns = document.getElementsByClassName("status-dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Animation pour les cartes
            const infoCards = document.querySelectorAll('.info-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            infoCards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>
</html>