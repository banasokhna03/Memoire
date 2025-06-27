<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivitySector;

class ActivitySectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sectors = ActivitySector::orderBy('name')->get();
        return view('admin.activity_sectors.index', compact('sectors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.activity_sectors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:activity_sectors',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // La valeur de la case à cocher is_active est '1' ou 'on' si elle est cochée, sinon elle n'est pas présente
        $isActive = $request->input('is_active') ? true : false;
        
        ActivitySector::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.activity-sectors.index')
            ->with('success', 'Secteur d\'activité créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sector = ActivitySector::findOrFail($id);
        return view('admin.activity_sectors.show', compact('sector'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sector = ActivitySector::findOrFail($id);
        return view('admin.activity_sectors.edit', compact('sector'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sector = ActivitySector::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:activity_sectors,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // La valeur de la case à cocher is_active est '1' ou 'on' si elle est cochée, sinon elle n'est pas présente
        $isActive = $request->input('is_active') ? true : false;
        
        $sector->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.activity-sectors.index')
            ->with('success', 'Secteur d\'activité modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sector = ActivitySector::findOrFail($id);
        $sector->delete();

        return redirect()->route('admin.activity-sectors.index')
            ->with('success', 'Secteur d\'activité supprimé avec succès.');
    }
}
