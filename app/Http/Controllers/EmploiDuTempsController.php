<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Classe;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    // 📊 INDEX
    public function index($classe_id)
    {
        $classe = Classe::findOrFail($classe_id);

        $emplois = EmploiDuTemps::where('classe_id', $classe_id)
                    ->orderBy('jour')
                    ->orderBy('heure_debut')
                    ->get();

        return view('emplois.index', compact('classe', 'emplois'));
    }

    // ➕ CREATE
    public function create($classe_id)
    {
        $classe = Classe::findOrFail($classe_id);
        return view('emplois.create', compact('classe'));
    }

    // 💾 STORE
    public function store(Request $request)
    {
        EmploiDuTemps::create($request->all());

        return back()->with('success', 'Cours ajouté');
    }

    // ✏️ EDIT
    public function edit($id)
    {
        $emploi = EmploiDuTemps::findOrFail($id);
        return view('emplois.edit', compact('emploi'));
    }

    // 🔄 UPDATE
    public function update(Request $request, $id)
    {
        $emploi = EmploiDuTemps::findOrFail($id);
        $emploi->update($request->all());

        return redirect()->back()->with('success', 'Modifié');
    }

    // 🗑️ DELETE
    public function destroy($id)
    {
        EmploiDuTemps::destroy($id);
        return back()->with('success', 'Supprimé');
    }
}
