<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Récupérer les offres en attente pour les afficher sur le tableau de bord
        $pendingOffers = Offer::where('is_validated', false)
                                 ->where('is_published', false)
                                 ->with('user') // Charger les informations de l'utilisateur
                                 ->orderBy('created_at', 'desc')
                                 ->get();

        $pendingOffersCount = $pendingOffers->count(); // Obtenir le compte à partir de la collection
        
        // Récupérer les candidatures récentes
        $recentApplications = Application::with(['user', 'offer'])
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();
        
        $pendingApplicationsCount = Application::where('status', 'pending')->count();
        
        // Débogage: ajouter un message flash pour vérifier les données (optionnel)
        session()->flash('debug', "Nombre d'offres trouvées: $pendingOffersCount");
                                 
        return view('admin.dashboard', compact('pendingOffersCount', 'pendingOffers', 'recentApplications', 'pendingApplicationsCount'));
    }

    public function users()
    {
        return view('admin.users');
    }
    
    /**
     * Afficher les offres en attente de validation
     */
    public function pendingOffers()
    {
        $pendingOffers = Offer::where('is_validated', false)
                             ->where('is_published', true)
                             ->with('user')
                             ->orderBy('created_at', 'desc')
                             ->get();
                             
        return view('admin.pending_offers', compact('pendingOffers'));
    }
    
    /**
     * Valider une offre spécifique
     */
    public function validateOffer(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        
        // Mettre à jour le statut de validation
        $offer->is_validated = true;
        $offer->is_published = true;
        $offer->save();
        
        return redirect()->back()->with('success', 'L\'offre a été validée avec succès.');
    }
    
    /**
     * Rejeter une offre spécifique
     */
    public function rejectOffer(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        
        // Option 1: Supprimer l'offre
        // $offer->delete();
        
        // Option 2: Marquer comme rejetée (nécessite un champ is_rejected dans la table)
        $offer->is_published = false; // Désactive la publication
        $offer->save();
        
        return redirect()->back()->with('success', 'L\'offre a été rejetée.');
    }
}
