<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postuler à l'offre {{ $offer->title }} - Appel d'Offres Sénégal</title>
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
    <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Bouton retour -->
        <div class="mb-6">
            <a href="{{ route('offers.show', $offer->id) }}" class="inline-flex items-center text-purple-700 hover:text-purple-900 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Retour aux détails de l'offre
            </a>
        </div>

        <!-- Formulaire de candidature -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="gradient-bg p-6">
                <h1 class="text-xl md:text-2xl font-bold text-white">Postuler à l'offre : {{ $offer->title }}</h1>
                <p class="text-purple-100 mt-2">
                    <i class="fas fa-building mr-2"></i> {{ $offer->company }}
                </p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-lg mt-1 mr-3"></i>
                        </div>
                        <div>
                            <p class="text-red-800 font-medium">Veuillez corriger les erreurs suivantes :</p>
                            <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('applications.store', $offer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Numéro de téléphone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                        <p class="text-xs text-gray-500 mt-1">Numéro où l'employeur peut vous contacter</p>
                    </div>
                    
                    <div>
                        <label for="cv" class="block text-sm font-medium text-gray-700 mb-1">CV (PDF, DOC ou DOCX)</label>
                        <div class="relative">
                            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Taille maximale : 2 Mo</p>
                    </div>
                    
                    <div>
                        <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Lettre de motivation</label>
                        <textarea id="cover_letter" name="cover_letter" rows="8" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>{{ old('cover_letter') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Décrivez pourquoi vous êtes le candidat idéal pour cette offre (100 caractères minimum)</p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="terms" name="terms" required class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                En soumettant ce formulaire, j'accepte que mes données soient traitées dans le cadre de ma candidature
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg font-medium transition-colors flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i> Soumettre ma candidature
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Pour toute question concernant votre candidature, veuillez contacter directement l'employeur.</p>
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