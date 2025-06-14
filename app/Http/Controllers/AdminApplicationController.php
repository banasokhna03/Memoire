<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class AdminApplicationController extends Controller
{
    /**
     * Afficher la liste des candidatures
     */
    public function index(Request $request)
    {
        $query = Application::query()->with(['user', 'offer']);
        
        // Filtrage par statut si spécifié
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $applications = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.applications.index', compact('applications'));
    }
    
    /**
     * Afficher les détails d'une candidature
     */
    public function show($id)
    {
        $application = Application::with(['user', 'offer'])->findOrFail($id);
        
        return view('admin.applications.show', compact('application'));
    }
    
    /**
     * Télécharger le CV d'un candidat
     */
    public function downloadCV($id)
    {
        $application = Application::findOrFail($id);
        
        // Vérifier que le chemin du CV existe
        if (!$application->cv_path) {
            return redirect()->back()->with('error', 'Le CV n\'est pas disponible (chemin non défini).');
        }
        
        // IMPORTANT: Les CV sont stockés sur le disque 'public' dans le dossier 'cvs'
        // comme on peut le voir dans ApplicationController::store()
        
        // Solution 1: Essayer de le télécharger directement depuis le disque public
        try {
            return Storage::disk('public')->download($application->cv_path, basename($application->cv_path));
        } catch (\Exception $e) {
            // Si ça ne fonctionne pas, essayons d'autres approches
        }
        
        // Solution 2: Essayer le chemin complet physique
        $publicPath = public_path('storage/' . $application->cv_path);
        if (file_exists($publicPath)) {
            return response()->download($publicPath, basename($application->cv_path));
        }
        
        // Solution 3: Essayer le chemin dans storage/app/public
        $storagePath = storage_path('app/public/' . $application->cv_path);
        if (file_exists($storagePath)) {
            return response()->download($storagePath, basename($application->cv_path));
        }
        
        // Solution d'urgence: Essayer de forcer le téléchargement via l'URL publique
        $publicUrl = asset('storage/' . $application->cv_path);
        return redirect($publicUrl);
    }
    
    /**
     * Mettre à jour le statut d'une candidature
     */
    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        
        // Valider que le statut est valide
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);
        
        // Mettre à jour le statut
        $application->status = $request->status;
        $application->save();
        
        return redirect()->back()->with('success', 'Le statut de la candidature a été mis à jour avec succès.');
    }
}
