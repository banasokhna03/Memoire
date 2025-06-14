<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
                      ->limit(4)
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

     public function archive(Request $request) // Il est bon de passer Request pour les filtres futurs
    {
        // On initialise la requête sur le modèle Offer
        $query = Offer::query();

        // On applique les conditions : seules les offres validées ET publiées
        $query->where('is_validated', true)
              ->where('is_published', true);

        // On trie les résultats par date de création, du plus récent au plus ancien
        $query->orderBy('created_at', 'desc');

        // On pagine les résultats (par exemple, 4 offres par page)
        $offers = $query->paginate(4);

        // On retourne la vue avec les offres paginées
        return view('offers.archive', compact('offers'));// Assurez-vous que le chemin de votre vue est correct, ex: 'offers.archive' ou juste 'archive'
    }

    public function conseil()
    {
        return view('offers.conseil');
    }

    /**
     * Display the specified offer
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::findOrFail($id);

        // Only display validated and published offers to regular users
        if (!auth()->user()?->is_admin && (!$offer->is_validated || !$offer->is_published)) {
            abort(404);
        }

        return view('offers.show', compact('offer'));
    }

    public function toggleSave(Offer $offer)
    {
        $user = auth()->user();

        if ($user->hasSavedOffer($offer->id)) {
            $user->savedOffers()->detach($offer->id);
            $saved = false;
        } else {
            $user->savedOffers()->attach($offer->id);
            $saved = true;
        }

        return response()->json(['saved' => $saved]);
    }
}
