<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Application;
use App\Models\User; // Assurez-vous d'importer le modèle User
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
        
        // Récupérer les offres validées et publiées (offres actives)
        $activeOffers = Offer::where('is_validated', true)
                            ->where('is_published', true)
                            ->with('user')
                            ->orderBy('created_at', 'desc')
                            ->get();
                            
        $activeOffersCount = $activeOffers->count();
            
        $users = User::latest()->take(5)->get(); // Ajout des utilisateurs récents

        // Récupérer les candidatures récentes
        $recentApplications = Application::with(['user', 'offer'])
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();
        
        $pendingApplicationsCount = Application::where('status', 'pending')->count();
        
        // Débogage: ajouter un message flash pour vérifier les données (optionnel)
        session()->flash('debug', "Nombre d'offres trouvées: $pendingOffersCount");
                                 
        return view('admin.dashboard', compact('pendingOffersCount', 'pendingOffers', 'activeOffers', 'activeOffersCount', 'recentApplications', 'pendingApplicationsCount', 'users'));
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
    
    /**
     * Supprimer une offre
     */
    public function deleteOffer(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        
        // Supprimer l'offre de la base de données
        $offer->delete();
        
        return redirect()->back()->with('success', 'L\'offre a été supprimée avec succès.');
    }
    
    /**
     * Afficher les offres actives et publiées
     */
    public function activeOffers()
    {
        $activeOffers = Offer::where('is_validated', true)
                            ->where('is_published', true)
                            ->with('user')
                            ->orderBy('created_at', 'desc')
                            ->get();
                            
        return view('admin.active_offers', compact('activeOffers'));
    }
    
    /**
     * Afficher le formulaire d'édition pour une offre
     */
    public function editOffer($id)
    {
        $offer = Offer::findOrFail($id);
        
        return view('admin.edit_offer', compact('offer'));
    }
    
    /**
     * Mettre à jour une offre
     */
    public function updateOffer(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'sector' => 'required|string',
            'region' => 'required|string',
            'budget' => 'nullable|numeric',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'deadline' => 'nullable|date',
            'duration' => 'nullable|string',
            'required_skills' => 'nullable|string',
        ]);
        
        // Mise à jour de l'offre
        $offer->update($validated);
        
        return redirect()->route('admin.offers.pending')
                         ->with('success', 'L\'offre a été mise à jour avec succès.');
    }
}