<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une Offre - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .form-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .input-highlight:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
        }
        .gradient-btn {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        }
        .gradient-btn:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
        }
        .description-box {
            min-height: 200px;
        }
        .login-required {
            background-color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Vérification de connexion -->
    @guest
    <div class="login-required fixed inset-0 z-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-xl max-w-md w-full mx-4">
            <div class="text-center mb-6">
                <i class="fas fa-lock text-4xl text-purple-600 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800">Accès restreint</h2>
                <p class="text-gray-600 mt-2">Vous devez être connecté pour publier une offre</p>
            </div>
            <div class="flex flex-col space-y-4">
                <a href="{{ url('/login') }}" class="gradient-btn text-white font-semibold py-3 rounded-lg text-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                </a>
                <a href="{{ url('/register') }}" class="bg-white text-purple-600 border border-purple-600 font-semibold py-3 rounded-lg text-center">
                    <i class="fas fa-user-plus mr-2"></i> Créer un compte
                </a>
            </div>
        </div>
    </div>
    @endguest

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
            <a href="{{ url('/archive') }}" class="text-gray-700 hover:text-purple-600 transition-colors">
                <i class="fas fa-search mr-1"></i> Offres
            </a>
            <a href="{{ url('/conseil') }}" class="text-gray-700 hover:text-purple-600 transition-colors">
                <i ></i> Conseils
            </a>
            @auth
            <a href="{{ url('/profile') }}" class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full hover:bg-purple-200 transition-colors">
                <i class="fas fa-user-circle mr-1"></i> Mon compte
            </a>
            @endauth
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition-colors">
            🚪 Déconnexion
        </button>
    </form>
        </div>
    </nav>

    <!-- Main Content (visible seulement si connecté) -->
    @auth
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header avec info utilisateur -->
        <div class="text-center mb-10">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-purple-100 p-3 rounded-full mr-4">
                    <i class="fas fa-user-tie text-purple-600 text-xl"></i>
                </div>
                <div class="text-left">
                    <p class="text-sm text-gray-600">Connecté en tant que</p>
                    <h3 class="font-medium text-purple-800">{{ Auth::user()->name }}</h3>
                </div>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-purple-800 mb-4">
                <i class="fas fa-bullhorn text-yellow-500 mr-3"></i> Sauvegarder Votre Offre
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Remplissez ce formulaire pour diffuser votre appel d'offres à notre réseau de professionnels qualifiés
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Form Progress -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center mr-3">
                                <span>1</span>
                            </div>
                            <span class="font-medium text-purple-700">Informations de base</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-center">
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mr-3">
                                <span>2</span>
                            </div>
                            <span class="font-medium text-gray-500">Détails techniques</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-end">
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mr-3">
                                <span>3</span>
                            </div>
                            <span class="font-medium text-gray-500">Validation</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Sections -->
            <form method="POST" action="/publish-offer" class="divide-y divide-gray-200" id="offerForm" enctype="multipart/form-data">
                @csrf
                
                @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Veuillez corriger les erreurs suivantes :</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                <!-- Section 1: Basic Info -->
                <div class="form-card p-6">
                    <h2 class="text-xl font-semibold text-purple-800 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-purple-600 mr-3"></i> Informations Générales
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Titre de l'offre *</label>
                            <input type="text" name="title" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none"
                                   placeholder="Ex: Développement d'une application mobile">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type d'offre *</label>
                            <select name="type" required class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none">
                                <option value="">Sélectionnez un type...</option>
                                <option value="public">Public</option>
                                <option value="prive">Privé</option>
                                <option value="international">International</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Secteur d'activité *</label>
                            <select name="sector" required class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none">
                                <option value="">Sélectionnez un secteur...</option>
                                <option value="informatique">Informatique & Télécommunications</option>
                                <option value="construction">Construction & BTP</option>
                                <option value="sante">Santé</option>
                                <option value="energie">Énergie</option>
                                <option value="agriculture">Agriculture</option>
                                <option value="transport">Transport & Logistique</option>
                                <option value="finance">Services Financiers</option>
                                <option value="education">Éducation & Formation</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Budget estimé (FCFA)</label>
                            <input type="number" name="budget" 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none"
                                   placeholder="Ex: 5000000">
                        </div>
                    </div>
                </div>
                
                <!-- Section 2: Description détaillée -->
                <div class="form-card p-6">
                    <h2 class="text-xl font-semibold text-purple-800 mb-6 flex items-center">
                        <i class="fas fa-align-left text-purple-600 mr-3"></i> Description Complète
                    </h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description détaillée *</label>
                        <textarea name="description" rows="8" required
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none description-box"
                                  placeholder="Décrivez en détail votre projet, les spécifications techniques, les objectifs, les livrables attendus et toute autre information pertinente..."></textarea>
                        <p class="text-xs text-gray-500 mt-1">Minimum 300 caractères</p>
                    </div>
                </div>
                
                <!-- Section 3: Technical Details -->
                <div class="form-card p-6">
                    <h2 class="text-xl font-semibold text-purple-800 mb-6 flex items-center">
                        <i class="fas fa-tools text-purple-600 mr-3"></i> Exigences Techniques
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date limite *</label>
                            <input type="date" name="deadline" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durée du projet</label>
                            <input type="text" name="duration" 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none"
                                   placeholder="Ex: 6 mois">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Compétences requises *</label>
                            <textarea name="required_skills" rows="4" required
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none"
                                      placeholder="Listez les compétences, certifications ou expériences spécifiques requises pour ce projet"></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Section 4: Contact Info -->
                <div class="form-card p-6">
                    <h2 class="text-xl font-semibold text-purple-800 mb-6 flex items-center">
                        <i class="fas fa-envelope text-purple-600 mr-3"></i> Coordonnées
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom de l'entreprise *</label>
                            <input type="text" name="company" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none"
                                   value="{{ Auth::user()->company ?? '' }}">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none"
                                   value="{{ Auth::user()->email }}">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                            <input type="tel" name="phone" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none"
                                   value="{{ Auth::user()->phone ?? '' }}">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Région *</label>
                            <select name="region" required class="w-full px-4 py-3 rounded-lg border border-gray-300 input-highlight focus:outline-none">
                                <option value="">Sélectionnez votre région...</option>
                                <option value="dakar">Dakar</option>
                                <option value="diourbel">Diourbel</option>
                                <option value="fatick">Fatick</option>
                                <option value="kaffrine">Kaffrine</option>
                                <option value="kaolack">Kaolack</option>
                                <option value="kedougou">Kédougou</option>
                                <option value="kolda">Kolda</option>
                                <option value="louga">Louga</option>
                                <option value="matam">Matam</option>
                                <option value="saint-louis">Saint-Louis</option>
                                <option value="sedhiou">Sédhiou</option>
                                <option value="tambacounda">Tambacounda</option>
                                <option value="thies">Thiès</option>
                                <option value="ziguinchor">Ziguinchor</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-center">
                    <div class="mb-4 sm:mb-0">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-lock mr-2 text-green-500"></i>
                            <span>Soumission sécurisée - Vos données sont protégées</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="submit" name="action" value="save" id="saveButton" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold px-6 py-3 rounded-lg border border-gray-300 transition-colors">
                            <i class="fas fa-save mr-2"></i> Sauvegarder
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Tips Section -->
        <div class="bg-purple-50 border-l-4 border-purple-400 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-purple-500 text-xl mt-1"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-purple-800">Conseils pour une bonne offre</h3>
                    <div class="mt-2 text-sm text-purple-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Soyez exhaustif dans votre description pour attirer les bons profils</li>
                            <li>Précisez bien les compétences et expériences requises</li>
                            <li>Indiquez clairement les délais et contraintes techniques</li>
                            <li>Relisez avant publication pour éviter les erreurs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endauth

    <!-- Footer -->
    <footer class="bg-purple-900 text-white py-8 mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">AppelOffresSN</h3>
                    <p class="text-purple-200 text-sm">
                        La plateforme de référence pour les appels d'offres au Sénégal.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Aide</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/faq') }}" class="text-purple-200 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-purple-200 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="{{ url('/terms') }}" class="text-purple-200 hover:text-white transition-colors">Conditions</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-purple-300"></i>
                            <span class="text-purple-200">contact@appeloffressn.sn</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-purple-300"></i>
                            <span class="text-purple-200">+221 33 123 45 67</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-purple-800 mt-8 pt-6 text-center text-purple-300 text-sm">
                <p>© 2023 AppelOffresSN. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Animation for form cards
        document.addEventListener('DOMContentLoaded', function() {
            const formCards = document.querySelectorAll('.form-card');
            
            formCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 150 * index);
            });

            // Character counter for description
            const descriptionTextarea = document.querySelector('.description-box');
            if (descriptionTextarea) {
                const charCounter = document.createElement('div');
                charCounter.className = 'text-xs text-gray-500 mt-1 text-right';
                descriptionTextarea.parentNode.appendChild(charCounter);

                descriptionTextarea.addEventListener('input', function() {
                    const charCount = this.value.length;
                    charCounter.textContent = `${charCount} caractères`;
                    
                    if(charCount < 300) {
                        charCounter.classList.add('text-red-500');
                        charCounter.classList.remove('text-green-500');
                    } else {
                        charCounter.classList.add('text-green-500');
                        charCounter.classList.remove('text-red-500');
                    }
                });
            }
            
            // Débogage du formulaire et assurer la soumission
            const offerForm = document.getElementById('offerForm');
            if (offerForm) {
                offerForm.addEventListener('submit', function(e) {
                    console.log('Formulaire soumis');
                    // Assurer que le formulaire est soumis
                    return true;
                });
                
                // Ajouter des gestionnaires d'événements pour les boutons
                const saveButton = document.getElementById('saveButton');
                const publishButton = document.getElementById('publishButton');
                
                if (saveButton) {
                    saveButton.addEventListener('click', function(e) {
                        console.log('Bouton Sauvegarder cliqué');
                        // Créer un champ caché pour l'action
                        const actionInput = document.createElement('input');
                        actionInput.type = 'hidden';
                        actionInput.name = 'action';
                        actionInput.value = 'save';
                        offerForm.appendChild(actionInput);
                    });
                }
                
                if (publishButton) {
                    publishButton.addEventListener('click', function(e) {
                        console.log('Bouton Publier cliqué');
                        // Créer un champ caché pour l'action
                        const actionInput = document.createElement('input');
                        actionInput.type = 'hidden';
                        actionInput.name = 'action';
                        actionInput.value = 'publish';
                        offerForm.appendChild(actionInput);
                    });
                }
            }
        });
    </script>
</body>
</html>