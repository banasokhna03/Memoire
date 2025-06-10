<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Affiche le formulaire de candidature pour une offre
     */
    public function create($offer_id)
    {
        $offer = \App\Models\Offer::findOrFail($offer_id);
        return view('applications.create', compact('offer'));
    }

    /**
     * Enregistre une nouvelle candidature
     */
    public function store(Request $request, $offer_id)
    {
        // Valider les données
        $validated = $request->validate([
            'cover_letter' => 'required|string|min:100',
            'phone' => 'required|string',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Récupérer l'offre
        $offer = \App\Models\Offer::findOrFail($offer_id);
        
        // Gérer l'upload du CV
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvFile = $request->file('cv');
            $fileName = time() . '_' . auth()->id() . '_' . $cvFile->getClientOriginalName();
            $cvPath = $cvFile->storeAs('cvs', $fileName, 'public');
        }
        
        // Créer la candidature
        $application = \App\Models\Application::create([
            'user_id' => auth()->id(),
            'offer_id' => $offer_id,
            'cover_letter' => $validated['cover_letter'],
            'phone' => $validated['phone'],
            'cv_path' => $cvPath,
            'status' => 'pending'
        ]);
        
        return redirect()->route('applications.success', $application->id)
            ->with('success', 'Votre candidature a été soumise avec succès!');
    }
    
    /**
     * Affiche la page de confirmation après une candidature réussie
     */
    public function success($id)
    {
        $application = \App\Models\Application::findOrFail($id);
        
        // Vérifier que l'utilisateur est bien le propriétaire de la candidature
        if (auth()->id() != $application->user_id) {
            abort(403);
        }
        
        return view('applications.success', compact('application'));
    }
    
    /**
     * Affiche la liste des candidatures de l'utilisateur
     */
    public function index()
    {
        $applications = auth()->user()->applications()->with('offer')->latest()->get();
        return view('applications.index', compact('applications'));
    }
}
