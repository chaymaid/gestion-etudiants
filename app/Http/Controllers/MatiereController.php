<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matiere;
use App\Models\Classe;

class MatiereController extends Controller
{
   public function index()
{
    $matieres = \App\Models\Matiere::with('classe')
        ->get()
        ->groupBy('classe.nom'); // 🔥 groupement

    return view('matieres.index', compact('matieres'));
}

    public function create()
    {
        $classes = Classe::all();
        return view('matieres.create', compact('classes'));
    }

    public function store(Request $request)
    {
        Matiere::create($request->all());
        return redirect()->route('matieres.index')->with('success', 'Matière ajoutée');
    }

    public function edit($id)
    {
        $matiere = Matiere::findOrFail($id);
        $classes = Classe::all();
        return view('matieres.edit', compact('matiere', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $matiere = Matiere::findOrFail($id);
        $matiere->update($request->all());
        return redirect()->route('matieres.index')->with('success', 'Matière modifiée');
    }

    public function destroy($id)
    {
        Matiere::findOrFail($id)->delete();
        return back()->with('success', 'Matière supprimée');
    }

    // 🔥 afficher matières d’une classe
    public function parClasse($id)
    {
        $classe = Classe::with('matieres')->findOrFail($id);
        return view('matieres.par_classe', compact('classe'));
    }
}
