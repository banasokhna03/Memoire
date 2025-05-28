<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | AppelOffresSN</title>
    @vite(['resources/css/app.css', 'resources/js/admin.js'])
    <style>
        .admin-nav {
            scrollbar-width: thin;
            scrollbar-color: #8b5cf6 #f5f3ff;
        }
        .admin-nav::-webkit-scrollbar {
            width: 6px;
        }
        .admin-nav::-webkit-scrollbar-track {
            background: #f5f3ff;
        }
        .admin-nav::-webkit-scrollbar-thumb {
            background-color: #8b5cf6;
            border-radius: 3px;
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }
        .blink-warning {
            animation: blink 2s infinite;
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800" x-data="adminApp()">
    <!-- Admin Layout -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-purple-800 border-r border-purple-700">
                <div class="flex items-center h-16 px-4 bg-purple-900">
                    <img src="{{ asset('images/logo-white.png') }}" class="h-8 w-auto mr-2" alt="Logo">
                    <span class="text-white font-bold">Admin Portal</span>
                </div>
                <div class="admin-nav flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <!-- Dashboard -->
                        <a href="#" @click="currentTab = 'dashboard'" :class="{'bg-purple-700': currentTab === 'dashboard'}" class="group flex items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Tableau de bord
                        </a>

                        <!-- User Management -->
                        <div x-data="{ userOpen: false }">
                            <button @click="userOpen = !userOpen" class="w-full flex justify-between items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                                <div class="flex items-center">
                                    <i class="fas fa-users-cog mr-3"></i>
                                    Gestion Utilisateurs
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'transform rotate-180': userOpen }"></i>
                            </button>
                            <div x-show="userOpen" class="mt-1 space-y-1 pl-12">
                                <a href="#" @click="currentTab = 'users'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Liste Utilisateurs</a>
                                <a href="#" @click="currentTab = 'createUser'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Créer Utilisateur</a>
                                <a href="#" @click="currentTab = 'roles'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Gestion Rôles</a>
                            </div>
                        </div>

                        <!-- Offer Management -->
                        <div x-data="{ offerOpen: false }">
                            <button @click="offerOpen = !offerOpen" class="w-full flex justify-between items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                                <div class="flex items-center">
                                    <i class="fas fa-file-contract mr-3"></i>
                                    Gestion Offres
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'transform rotate-180': offerOpen }"></i>
                            </button>
                            <div x-show="offerOpen" class="mt-1 space-y-1 pl-12">
                                <a href="#" @click="currentTab = 'pendingOffers'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Offres en Attente <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-1">12</span></a>
                                <a href="#" @click="currentTab = 'activeOffers'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Offres Actives</a>
                                <a href="#" @click="currentTab = 'archivedOffers'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Archive</a>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <a href="#" @click="currentTab = 'stats'" :class="{'bg-purple-700': currentTab === 'stats'}" class="group flex items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                            <i class="fas fa-chart-pie mr-3"></i>
                            Statistiques
                        </a>

                        <!-- System -->
                        <div x-data="{ systemOpen: false }">
                            <button @click="systemOpen = !systemOpen" class="w-full flex justify-between items-center px-4 py-2 text-sm text-white hover:bg-purple-700 rounded-md">
                                <div class="flex items-center">
                                    <i class="fas fa-cogs mr-3"></i>
                                    Configuration
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'transform rotate-180': systemOpen }"></i>
                            </button>
                            <div x-show="systemOpen" class="mt-1 space-y-1 pl-12">
                                <a href="#" @click="currentTab = 'settings'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Paramètres</a>
                                <a href="#" @click="currentTab = 'backup'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Sauvegarde</a>
                                <a href="#" @click="currentTab = 'audit'" class="block px-4 py-2 text-sm text-purple-200 hover:bg-purple-600 rounded">Journal d'audit</a>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="p-4 border-t border-purple-700">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                            <a href="{{ route('logout') }}" class="text-xs font-medium text-purple-200 hover:text-white">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Mobile Topbar -->
            <div class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200">
                <button @click="mobileMenuOpen = true" class="text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-lg font-semibold" x-text="getTabTitle(currentTab)"></h1>
                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
            </div>

            <!-- Mobile Sidebar -->
            <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="fixed inset-0 z-40 md:hidden">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
                <div class="fixed inset-0 flex z-50">
                    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-purple-800">
                        <div class="absolute top-0 right-0 -mr-12 pt-2">
                            <button @click="mobileMenuOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none">
                                <i class="fas fa-times text-white text-xl"></i>
                            </button>
                        </div>
                        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                            <div class="flex-shrink-0 flex items-center px-4">
                                <img src="{{ asset('images/logo-white.png') }}" class="h-8 w-auto mr-2" alt="Logo">
                                <span class="text-white font-bold">Admin Portal</span>
                            </div>
                            <nav class="mt-5 px-2 space-y-1">
                                <!-- Mobile menu items same as desktop -->
                            </nav>
                        </div>
                        <div class="p-4 border-t border-purple-700">
                            <!-- Same user panel as desktop -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <main class="flex-1 pb-8">
                <!-- Dashboard Header -->
                <div class="bg-white shadow">
                    <div class="px-4 sm:px-6 lg:max-w-7xl lg:mx-auto lg:px-8">
                        <div class="py-6 flex items-center justify-between">
                            <h1 class="text-2xl font-bold text-gray-900" x-text="getTabTitle(currentTab)"></h1>
                            <div class="flex space-x-3">
                                <button class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700">
                                    <i class="fas fa-download mr-2"></i> Exporter
                                </button>
                                <button x-show="currentTab === 'pendingOffers'" class="bg-red-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-600 blink-warning">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> 12 en attente
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content Sections -->
                <div class="mt-8 px-4 sm:px-6 lg:max-w-7xl lg:mx-auto lg:px-8">
                    <!-- Dashboard Tab -->
                    <template x-if="currentTab === 'dashboard'">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            <!-- Stat Cards -->
                            <div class="stat-card bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-purple-100 p-3 rounded-full">
                                            <i class="fas fa-users text-purple-600 stat-icon"></i>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">Utilisateurs</dt>
                                                <dd class="flex items-baseline">
                                                    <div class="text-2xl font-semibold text-gray-900">1,248</div>
                                                    <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                                        <i class="fas fa-arrow-up mr-1"></i> 12%
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- More stat cards... -->
                        </div>
                    </template>

                    <!-- Users Tab -->
                    <template x-if="currentTab === 'users'">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Liste des Utilisateurs</h3>
                                <div class="relative">
                                    <input type="text" placeholder="Rechercher..." class="pl-10 pr-4 py-2 border rounded-md text-sm">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscription</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- User rows would be dynamically generated -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/1.jpg" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">John Doe</div>
                                                        <div class="text-sm text-gray-500">Administrateur</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">john@example.com</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/10/2023</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button class="text-purple-600 hover:text-purple-900 mr-3"><i class="fas fa-edit"></i></button>
                                                <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                                <!-- Pagination -->
                            </div>
                        </div>
                    </template>

                    <!-- Pending Offers Tab -->
                    <template x-if="currentTab === 'pendingOffers'">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Offres en Attente de Validation</h3>
                                <p class="mt-1 text-sm text-gray-500">12 offres nécessitent votre approbation</p>
                            </div>
                            <ul class="divide-y divide-gray-200">
                                <!-- Offer items would be dynamically generated -->
                                <li class="px-6 py-4 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="bg-yellow-100 p-2 rounded-full mr-4">
                                                <i class="fas fa-exclamation text-yellow-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Construction d'une école primaire</p>
                                                <p class="text-sm text-gray-500">Soumis par: Entreprise XYZ • 12/11/2023</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-check"></i> Valider
                                            </button>
                                            <button class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-times"></i> Rejeter
                                            </button>
                                            <button class="text-purple-600 hover:text-purple-800">
                                                <i class="fas fa-eye"></i> Voir
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </template>

                    <!-- Other tabs would follow the same pattern -->
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine JS Controller -->
    <script>
        function adminApp() {
            return {
                currentTab: 'dashboard',
                mobileMenuOpen: false,
                getTabTitle(tab) {
                    const titles = {
                        'dashboard': 'Tableau de Bord',
                        'users': 'Gestion Utilisateurs',
                        'pendingOffers': 'Offres en Attente',
                        // Add other tab titles
                    };
                    return titles[tab] || 'Tableau de Bord';
                },
                // Additional methods for data fetching, etc.
            };
        }
    </script>
</body>
</html>