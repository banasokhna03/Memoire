<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\ActivitySector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function create()
    {
        $activitySectors = ActivitySector::where('is_active', true)->orderBy('name')->get();
        return view('offers.create', compact('activitySectors'));
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

     public function archive(Request $request)
    {
        // On initialise la requête sur le modèle Offer
        $query = Offer::query();

        // On applique les conditions : seules les offres validées ET publiées
        $query->where('is_validated', true)
              ->where('is_published', true);
              
        // Application des filtres sélectionnés par l'utilisateur
        
        // Filtre par type d'offre
        if ($request->has('type') && $request->type !== 'Tous types') {
            $query->where('type', $request->type);
        }
        
        // Filtre par secteur d'activité
        if ($request->has('sector') && $request->sector !== 'Tous secteurs') {
            $query->where('sector', $request->sector);
        }
        
        // Filtre par date limite
        if ($request->has('deadline') && $request->deadline !== 'Toutes dates') {
            switch($request->deadline) {
                case 'Cette semaine':
                    $query->whereBetween('deadline', [now(), now()->endOfWeek()]);
                    break;
                case 'Ce mois':
                    $query->whereBetween('deadline', [now(), now()->endOfMonth()]);
                    break;
                case 'Prochains 3 mois':
                    $query->whereBetween('deadline', [now(), now()->addMonths(3)]);
                    break;
            }
        }
        
        // Tri des offres
        if ($request->has('sort')) {
            switch($request->sort) {
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'budget_desc':
                    $query->orderBy('budget', 'desc');
                    break;
                case 'budget_asc':
                    $query->orderBy('budget', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            // Par défaut, on trie les résultats du plus récent au plus ancien
            $query->orderBy('created_at', 'desc');
        }

        // On pagine les résultats
        $offers = $query->paginate(9)->appends($request->except('page')); // Ajoute les filtres aux liens de pagination
        $offers = $query->paginate(6);

        // On retourne la vue avec les offres paginées et les filtres sélectionnés
        return view('offers.archive', compact('offers'));
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
