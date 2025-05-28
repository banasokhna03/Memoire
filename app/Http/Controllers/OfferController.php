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
        $offers = Offer::where('is_validated', true)->get();
        return view('offers.index', compact('offers'));
    }

    // Si tu souhaites gérer l'enregistrement d'une offre
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            // autres règles...
        ]);

        // Création d'une nouvelle offre (non validée par défaut)
        Offer::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_validated' => false, // ou true si tu veux auto-valider
        ]);

        return redirect()->route('offers.index')->with('success', 'Offre créée avec succès !');
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
