<?php
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
    <title>Gestion des candidatures - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1 0 auto;
        }
        .footer {
            flex-shrink: 0;
        }
        .application-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .application-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-accepted {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .table-responsive {
            width: 100%;
            overflow-x: visible;
        }
        .table-full {
            width: 100%;
            table-layout: auto;
        }
    </style>
</head>
<body class="bg-gray-50 text-purple-900 font-sans flex flex-col min-h-screen">
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
    <main class="main-content max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-purple-900 flex items-center">
                <i class="fas fa-users mr-3 text-purple-600"></i> Gestion des candidatures
            </h1>
            <p class="text-purple-600 bg-purple-100 px-3 py-1 rounded-full text-sm font-medium">
                {{ $applications->total() }} candidature(s)
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 animate__animated animate__fadeIn" role="alert">
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

        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 w-full">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div class="flex items-center space-x-4">
                    <form method="GET" action="{{ route('admin.applications.index') }}" class="flex-1">
                        <div class="relative">
                            <select name="status" onchange="this.form.submit()" class="w-full md:w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Tous les statuts</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Acceptées</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refusées</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <i class="fas fa-filter text-gray-400"></i>
                            </div>
                        </div>
                    </form>
                    @if(request('status'))
                        <a href="{{ route('admin.applications.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            <i class="fas fa-times mr-1"></i> Réinitialiser
                        </a>
                    @endif
                </div>
            </div>

            @if($applications->count() > 0)
                <div class="table-responsive">
                    <table class="table-full min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Offre</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DOC</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><center>Actions</center></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($applications as $application)
                                <tr class="application-card hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-normal">
                                        <div class="text-sm font-medium text-gray-900">{{ $application->user ? $application->user->name : 'Utilisateur supprimé' }}</div>
                                        <div class="text-sm text-gray-500">{{ $application->user ? $application->user->email : 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal">
                                        <div class="text-sm text-gray-900">{{ $application->offer ? $application->offer->title : 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray-500">
                                        {{ $application->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal">
                                        @if($application->status == 'pending')
                                            <span class="status-pending px-2 py-1 rounded-full text-xs font-semibold">En attente</span>
                                        @elseif($application->status == 'accepted')
                                            <span class="status-accepted px-2 py-1 rounded-full text-xs font-semibold">Acceptée</span>
                                        @elseif($application->status == 'rejected')
                                            <span class="status-rejected px-2 py-1 rounded-full text-xs font-semibold">Refusée</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray-500">
                                        @if($application->cv_path)
                                            <a href="{{ route('admin.applications.download-cv', $application->id) }}" class="text-purple-600 hover:text-purple-800" target="_blank">
                                                <i class="fas fa-download mr-1"></i> Télécharger
                                            </a>
                                        @else
                                            <span class="text-gray-400">Aucun CV</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm font-medium">
                                        <div class="flex flex-nowrap gap-4 min-w-[260px]">
                                            <a href="{{ route('admin.applications.show', $application->id) }}" class="text-purple-600 hover:text-purple-900 whitespace-nowrap">
                                                <i class="fas fa-eye mr-1"></i> Détails
                                            </a>
                                            <form method="POST" action="{{ route('admin.applications.update-status', $application->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="text-green-600 hover:text-green-800 whitespace-nowrap">
                                                    <i class="fas fa-check mr-1"></i> Accepter
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.applications.update-status', $application->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="text-red-600 hover:text-red-800 whitespace-nowrap">
                                                    <i class="fas fa-times mr-1"></i> Refuser
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-600 mb-2">Aucune candidature trouvée</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Aucune candidature ne correspond à vos critères de recherche.</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer fixe -->
    <footer class="footer bg-purple-900 text-white py-6 w-full">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-purple-800 pt-6 text-center text-purple-300 text-sm">
                <p>© {{ date('Y') }} AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation pour les cartes de candidature
            const applicationCards = document.querySelectorAll('.application-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            applicationCards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>
</html>