<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Carbon;
class OfferController extends Controller
{
    public function create()
    {
        return view('offers.create');
    }

    public function index()
    {
        $offers = Offer::where('is_validated', true)
                      ->where('is_published', true)
                      ->get();
        return view('offers.index', compact('offers'));
    }

    /**
     * Enregistrer une nouvelle offre
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:300',
            'type' => 'required|string',
            'sector' => 'required|string',
            'budget' => 'nullable|numeric',
            'deadline' => 'required|date',
            'duration' => 'nullable|string',
            'required_skills' => 'required|string',
            'company' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'region' => 'required|string',
        ]);

        // Déterminer si l'offre est publiée directement ou sauvegardée comme brouillon
        $isPublished = $request->action === 'publish';

        // Création d'une nouvelle offre
        $offer = Offer::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'sector' => $validated['sector'],
            'budget' => $validated['budget'],
            'deadline' => $validated['deadline'],
            'duration' => $validated['duration'],
            'required_skills' => $validated['required_skills'],
            'company' => $validated['company'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'region' => $validated['region'],
            'user_id' => auth()->id(),
            'is_published' => $isPublished,
            'is_validated' => false, // Les offres doivent être validées par un administrateur
            'created_at' => now(),
        ]);

        // Message selon l'action effectuée
        $message = $isPublished 
            ? 'Votre offre a été soumise avec succès et sera publiée après validation par un administrateur.' 
            : 'Votre offre a été sauvegardée comme brouillon.'; 

        // Rediriger vers la page d'accueil au lieu d'offers.index qui n'existe pas
        return redirect()->route('home')->with('success', $message);
    }
public function archive(Request $request)
{
    $query = Offer::whereDate('deadline', '<', Carbon::today());

    // Filtre par type si précisé
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Filtre par recherche si précisé
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Tri
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'deadline':
                $query->orderBy('deadline', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $offers = $query->paginate(6);

    return view('offers.archive', compact('offers'));
}
public function conseil()
{
    return view('offers.conseil');
}
}
