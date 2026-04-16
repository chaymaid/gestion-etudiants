<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Etudiant;
use App\Models\Classe;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
public function index(Request $request)
{
    $search = $request->search;

    $classes = Classe::withCount('inscriptions')
        ->with(['inscriptions' => function ($q) use ($search) {

            $q->with('etudiant');

            // 🔍 filtre recherche
            if ($search) {
                $q->whereHas('etudiant', function ($query) use ($search) {
                    $query->where('nom_complet', 'like', "%$search%");
                });
            }

        }])
        ->get();

    return view('inscriptions.index', compact('classes', 'search'));
}

    public function create()
    {
        $etudiants = Etudiant::all();
        $classes = Classe::all();
        return view('inscriptions.create', compact('etudiants','classes'));
    }

    public function store(Request $request)
    {
        Inscription::create($request->all());
        return redirect()->route('inscriptions.index');
    }

    public function edit(Inscription $inscription)
    {
        $etudiants = Etudiant::all();
        $classes = Classe::all();
        return view('inscriptions.edit', compact('inscription','etudiants','classes'));
    }

    public function update(Request $request, Inscription $inscription)
    {
        $inscription->update($request->all());
        return redirect()->route('inscriptions.index');
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return back();
    }

}
