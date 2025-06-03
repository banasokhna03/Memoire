import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Fonction pour le tableau de bord administrateur
window.adminApp = function() {
    return {
        currentTab: 'dashboard',
        mobileMenuOpen: false,
        getTabTitle(tab) {
            const titles = {
                'dashboard': 'Tableau de bord',
                'users': 'Gestion Utilisateurs',
                'createUser': 'Créer Utilisateur',
                'roles': 'Gestion Rôles',
                'pendingOffers': 'Offres en Attente',
                'activeOffers': 'Offres Actives',
                'archivedOffers': 'Archives',
                'stats': 'Statistiques',
                'settings': 'Paramètres',
                'backup': 'Sauvegarde',
                'audit': 'Journal d\'audit'
            };
            return titles[tab] || 'Tableau de bord';
        }
    };
};

Alpine.start();
