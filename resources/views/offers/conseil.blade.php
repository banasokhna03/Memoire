<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conseils pour Publier des Offres - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition-colors">
                    🚪 Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-purple-800 mb-6 text-center">Conseils pour Publier des Offres</h1>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-purple-800 mb-4">1. Rédigez un Titre Clair et Précis</h2>
            <p class="text-gray-600 mb-4">Le titre de votre offre doit être concis et décrire clairement ce que vous proposez. Évitez les termes vagues.</p>

            <h2 class="text-xl font-semibold text-purple-800 mb-4">2. Détaillez Votre Offre</h2>
            <p class="text-gray-600 mb-4">Fournissez des informations détaillées sur votre offre, y compris les spécifications, les conditions et les avantages.</p>

            <h2 class="text-xl font-semibold text-purple-800 mb-4">3. Utilisez des Images de Qualité</h2>
            <p class="text-gray-600 mb-4">Des images de haute qualité peuvent attirer plus d'attention. Assurez-vous qu'elles sont pertinentes et bien éclairées.</p>

            <h2 class="text-xl font-semibold text-purple-800 mb-4">4. Fixez un Prix Compétitif</h2>
            <p class="text-gray-600 mb-4">Faites des recherches sur le marché pour vous assurer que votre prix est compétitif par rapport aux offres similaires.</p>

            <h2 class="text-xl font-semibold text-purple-800 mb-4">5. Répondez Rapidement aux Questions</h2>
            <p class="text-gray-600 mb-4">Soyez réactif aux questions des potentiels acheteurs. Une bonne communication peut faire la différence.</p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-purple-900 text-white py-8 mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-purple-800 mt-8 pt-6 text-center text-purple-300 text-sm">
                <p>© 2023 AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

</body>
</html> je veux inserer cette page sur mon site