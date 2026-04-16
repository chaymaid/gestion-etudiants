<?php

namespace App\Http\Controllers;

use App\Models\Quran;
use App\Models\Classe;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class QuranController extends Controller
{
public function index(Request $request)
{
    $classes = Classe::all();

    $classe_id = $request->classe_id;
    $etudiant_id = $request->etudiant_id;

    $classe = null;
    $etudiants = [];
    $qurans = [];

    // 📚 Charger classe + étudiants
    if ($classe_id) {
        $classe = Classe::with('etudiants')->find($classe_id);
        $etudiants = $classe ? $classe->etudiants : [];
    }

    // 📖 Charger Quran via relation
    if ($etudiant_id) {
        $etudiant = Etudiant::with('qurans')->find($etudiant_id);
        $qurans = $etudiant ? $etudiant->qurans()->orderBy('date', 'desc')->get() : [];
    }

    return view('quran.index', compact(
        'classes',
        'classe_id',
        'etudiant_id',
        'etudiants',
        'qurans'
    ));
}

    public function create(Request $request)
    {
        $etudiant_id = $request->etudiant_id;
        return view('quran.create', compact('etudiant_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required',
            'hizb' => 'nullable',
            'juz' => 'nullable',
            'type' => 'required',
            'note' => 'nullable|integer',
            'date' => 'required|date',
        ]);

        Quran::create($request->all());

        return redirect()->route('quran.index')->with('success', 'Note ajoutée');
    }

    public function edit(Quran $quran)
    {
        return view('quran.edit', compact('quran'));
    }

    public function update(Request $request, Quran $quran)
    {
        $quran->update($request->all());

        return redirect()->route('quran.index')->with('success', 'Modifié');
    }

    public function destroy(Quran $quran)
    {
        $quran->delete();

        return redirect()->route('quran.index')->with('success', 'Supprimé');
    }
}
