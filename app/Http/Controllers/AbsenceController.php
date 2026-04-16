<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Etudiant;

class AbsenceController extends Controller
{
public function index(Request $request)
{
    $search = $request->search;
    $date = $request->date;

    $classes = \App\Models\Classe::with(['etudiants' => function ($q) {
        $q->withCount('absences'); // ✅ compteur réel
    }, 'etudiants.absences' => function ($q) use ($search, $date) {

        if ($search) {
            $q->whereHas('etudiant', function ($query) use ($search) {
                $query->where('nom_complet', 'like', "%$search%");
            });
        }

        if ($date) {
            $q->whereDate('date', $date);
        }

    }])->get();

    return view('absences.index', compact('classes'));
}

    public function create()
    {
        $etudiants = Etudiant::all();
        return view('absences.create', compact('etudiants'));
    }

    public function store(Request $request)
    {
        Absence::create($request->all());
        return redirect()->route('absences.index');
    }
    public function edit($id)
{
    $absence = Absence::findOrFail($id);
    $etudiants = Etudiant::all();

    return view('absences.edit', compact('absence', 'etudiants'));
}

public function update(Request $request, $id)
{
    $absence = Absence::findOrFail($id);
    $absence->update($request->all());

    return redirect()->route('absences.index')
        ->with('success', 'Absence modifiée avec succès');
}

public function destroy($id)
{
    Absence::findOrFail($id)->delete();

    return redirect()->route('absences.index')
        ->with('success', 'Absence supprimée avec succès');
}
}
