<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .profile-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        /* Ajoutez cette règle pour le footer */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Assurez-vous que le corps prend toute la hauteur de la fenêtre */
        }
        main {
            flex-grow: 1; /* Permet au main de prendre tout l'espace disponible */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navigation -->
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center sticky top-0 z-40">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
            <span class="text-xl font-bold text-green-600">AppelOffres<span class="text-purple-700">SN</span></span>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-purple-600 transition-colors">
                <i class="fas fa-home mr-1"></i> Accueil
            </a>
            <a href="{{ url('/profile') }}" class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full hover:bg-purple-200 transition-colors">
                <i class="fas fa-user-circle mr-1"></i> Mon compte
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-purple-600 transition-colors">
                    🚪 Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    @auth
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-purple-800 mb-6 text-center">Mon Profil</h1>

        <div class="bg-white rounded-xl shadow-lg p-20 profile-card">
            <h2 class="text-xl font-semibold text-purple-800 mb-4">Informations Personnelles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom</label>
                    <p class="text-gray-600">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <p class="text-gray-600">{{ Auth::user()->phone ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                    <p class="text-gray-600">{{ Auth::user()->company ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Région</label>
                    <p class="text-gray-600">{{ Auth::user()->region ?? 'Non renseigné' }}</p>
                </div>
            </div>
        </div>
    </main>
    @endauth

    <!-- Footer -->
    <footer class="bg-purple-900 text-white py-8 mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-purple-800 mt-8 pt-6 text-center text-purple-300 text-sm">
                <p>© 2023 AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

</body>
</html>
