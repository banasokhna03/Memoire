<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidature soumise avec succès - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
    <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="gradient-bg p-6 text-center">
                <div class="inline-block bg-white rounded-full p-3 mb-4 animate__animated animate__bounceIn">
                    <i class="fas fa-check-circle text-4xl text-green-500"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Candidature soumise avec succès !</h1>
            </div>

            <div class="p-8 text-center">
                <div class="max-w-2xl mx-auto">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Merci pour votre candidature</h2>
                    <p class="text-gray-600 mb-6">
                        Votre candidature pour l'offre <span class="font-medium text-purple-700">{{ $application->offer->title }}</span> a bien été enregistrée.
                        L'entreprise <span class="font-medium">{{ $application->offer->company }}</span> va examiner votre profil et vous contactera prochainement.
                    </p>
                    
                    <div class="bg-purple-50 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-medium text-purple-800 mb-3">À propos de votre candidature</h3>
                        <ul class="text-left space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-calendar-check text-purple-600 mr-3"></i>
                                <span>Date de soumission : <span class="font-medium">{{ $application->created_at->format('d/m/Y à H:i') }}</span></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-file-alt text-purple-600 mr-3"></i>
                                <span>CV joint : <span class="font-medium">Oui</span></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope text-purple-600 mr-3"></i>
                                <span>Email de contact : <span class="font-medium">{{ auth()->user()->email }}</span></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone-alt text-purple-600 mr-3"></i>
                                <span>Téléphone : <span class="font-medium">{{ $application->phone }}</span></span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="flex flex-col md:flex-row justify-center gap-4">
                        <a href="{{ route('offers.show', $application->offer_id) }}" class="bg-white hover:bg-gray-50 border border-purple-200 text-purple-700 font-medium px-6 py-3 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i> Retour à l'offre
                        </a>
                        <a href="{{ route('applications.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-3 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-list mr-2"></i> Voir mes candidatures
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
