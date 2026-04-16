<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Liste des classes
     */
    public function index()
    {
        // 🔥 avec nombre d'étudiants
        $classes = Classe::withCount('etudiants')->get();

        return view('classes.index', compact('classes'));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Enregistrer classe
     */
    public function store(Request $request)
    {
        // ✅ validation
        $request->validate([
            'nom' => 'required|string|max:255|unique:classes,nom'
        ]);

        // ✅ création sécurisée
        Classe::create([
            'nom' => $request->nom
        ]);

        return redirect()->route('classes.index')
            ->with('success', 'Classe ajoutée avec succès ✅');
    }

    /**
     * Formulaire modification
     */
    public function edit($id)
    {
        $classe = Classe::findOrFail($id);

        return view('classes.edit', compact('classe'));
    }

    /**
     * Mettre à jour classe
     */
    public function update(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);

        // ✅ validation (ignore l'actuelle)
        $request->validate([
            'nom' => 'required|string|max:255|unique:classes,nom,' . $classe->id
        ]);

        // ✅ update sécurisé
        $classe->update([
            'nom' => $request->nom
        ]);

        return redirect()->route('classes.index')
            ->with('success', 'Classe modifiée avec succès ✏️');
    }

    /**
     * Supprimer classe
     */
    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);

        $classe->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Classe supprimée avec succès 🗑️');
    }
    
}
