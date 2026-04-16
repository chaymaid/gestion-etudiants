<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Classe;
use Barryvdh\DomPDF\Facade\Pdf;
class EtudiantController extends Controller
{

// 📊 LISTE
public function index(Request $request)
{
    $search = $request->search;

    $classes = Classe::with(['etudiants' => function ($query) use ($search) {

        if ($search) {
            $query->where('nom_complet', 'like', '%' . $search . '%');
        }

    }])->get();

    if ($search) {
        $classes = $classes->filter(fn($c) => $c->etudiants->count() > 0);
    }

    return view('etudiants.index', compact('classes'));
}


// ➕ CREATE
public function create()
{
    $classes = Classe::all();
    $etudiants = Etudiant::all();

    return view('etudiants.create', compact('classes', 'etudiants'));
}


// 💾 STORE
public function store(Request $request)
{
    $data = $request->all();

    // 📷 PHOTO
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('etudiants', 'public');
    }

    // 👨‍👩‍👧‍👦 FAMILLE
    if (!empty($request->freres)) {

        $famille_id = 'FAM-' . time();

        // 🔥 créer d'abord l'étudiant
        $etudiant = Etudiant::create([
            ...$data,
            'famille_id' => $famille_id,
            'mois_payes' => []
        ]);

        // 🔥 ajouter les frères + lui-même
        $ids = $request->freres;
        $ids[] = $etudiant->id;

        Etudiant::whereIn('id', $ids)
            ->update(['famille_id' => $famille_id]);

    } else {

        Etudiant::create([
            ...$data,
            'famille_id' => null,
            'mois_payes' => []
        ]);
    }

    return redirect()->route('etudiants.index');
}

// ✏️ EDIT
public function edit($id)
{
    $etudiant = Etudiant::findOrFail($id);
    $classes = Classe::all();
    $etudiants = Etudiant::all();

    $freres_ids = [];

    if ($etudiant->famille_id) {
        $freres_ids = Etudiant::where('famille_id', $etudiant->famille_id)
            ->where('id', '!=', $etudiant->id)
            ->pluck('id')
            ->toArray();
    }

    return view('etudiants.edit', compact(
        'etudiant',
        'classes',
        'etudiants',
        'freres_ids'
    ));
}


// 🔄 UPDATE
public function update(Request $request, $id)
{
    $etudiant = Etudiant::findOrFail($id);
    $data = $request->all();

    // 📷 PHOTO
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('etudiants', 'public');
    }

    // 👨‍👩‍👧‍👦 FAMILLE
   if (!empty($request->freres)) {

    $famille_id = $etudiant->famille_id ?? 'FAM-' . time();

    $ids = $request->freres;
    $ids[] = $etudiant->id;

    // ✅ CORRECTION ICI
    Etudiant::whereIn('id', $ids)->update([
        'famille_id' => $famille_id
    ]);

    $data['famille_id'] = $famille_id;

}else {
        $etudiant->update(['famille_id' => null]);
        $data['famille_id'] = null;
    }

    // 📅 garder ancien mois_payes (ne pas écraser)
    unset($data['mois_payes']);

    // 💰 PRIX
    $nb = count($request->freres ?? []) + 1;

    if ($nb == 1) $data['prix'] = 80;
    elseif ($nb == 2) $data['prix'] = 100;
    else $data['prix'] = 130;

    $etudiant->update($data);

    return redirect()->route('etudiants.index');
}


// 💰 PAIEMENT (TOGGLE + FAMILLE + ANNÉE)
public function payerMois(Request $request, $id)
{
    $etudiant = Etudiant::findOrFail($id);

    $mois = $request->mois;
    $annee = $request->annee ?? date('Y');

    $famille = $etudiant->famille_id
        ? Etudiant::where('famille_id', $etudiant->famille_id)->get()
        : collect([$etudiant]);

    // ✅ 1. prendre référence (le plus complet)
    $reference = [];

    foreach ($famille as $membre) {

        $data = $membre->mois_payes;

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        if (is_array($data)) {
            foreach ($data as $an => $moisList) {

                if (!isset($reference[$an])) {
                    $reference[$an] = [];
                }

                $reference[$an] = array_merge($reference[$an], $moisList);
            }
        }
    }

    // ✅ 2. ajouter le nouveau mois
    if (!isset($reference[$annee])) {
        $reference[$annee] = [];
    }

    if (!in_array($mois, $reference[$annee])) {
        $reference[$annee][] = $mois;
    }

    // ✅ 3. nettoyer
    foreach ($reference as $an => $list) {
        $reference[$an] = array_values(array_unique($list));
    }

    // ✅ 4. appliquer à toute la famille
    foreach ($famille as $membre) {
        $membre->update([
            'mois_payes' => $reference
        ]);
    }

    return back()->with('success', 'Famille synchronisée toutes années ✅');
}

// 👁️ SHOW
public function show($id)
{
    $etudiant = Etudiant::findOrFail($id);

    return view('etudiants.show', compact('etudiant'));
}


// ❌ DELETE
public function destroy($id)
{
    $etudiant = Etudiant::findOrFail($id);

    $etudiant->delete();

    return back();
}
public function lierFreres(Request $request)
{
    $ids = $request->ids; // tableau des étudiants sélectionnés

    if (!$ids || count($ids) < 2) {
        return back()->with('error', 'Sélectionnez au moins 2 étudiants');
    }

    // 🔥 créer une famille unique
    $famille_id = 'FAM-' . time();

    Etudiant::whereIn('id', $ids)
        ->update(['famille_id' => $famille_id]);

    return back()->with('success', 'Frères liés avec succès 👨‍👩‍👧‍👦');
}
public function supprimerMois(Request $request, $id)
{
    $etudiant = Etudiant::findOrFail($id);

    $mois = $request->mois;
    $annee = $request->annee;

    $famille = $etudiant->famille_id
        ? Etudiant::where('famille_id', $etudiant->famille_id)->get()
        : collect([$etudiant]);

    foreach ($famille as $membre) {

        $data = $membre->mois_payes;

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        if (!isset($data[$annee])) continue;

        $data[$annee] = array_diff($data[$annee], [$mois]);
        $data[$annee] = array_values($data[$annee]);

        $membre->update([
            'mois_payes' => $data
        ]);
    }

    return back()->with('success', 'Mois supprimé pour toute la famille ❌');
}




public function factureFamille($id)
{
    $etudiant = Etudiant::findOrFail($id);

    $famille = $etudiant->famille_id
        ? Etudiant::where('famille_id', $etudiant->famille_id)->with('classe')->get()
        : collect([$etudiant]);

    // ✅ numéro facture
    $numero = 'FAC-' . date('Ymd') . '-' . rand(1000, 9999);

    $date = now()->format('d/m/Y');

    // 📅 mois payés
    $moisPayes = [];

    foreach ($famille as $membre) {

        $data = $membre->mois_payes;

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        if (is_array($data)) {
            foreach ($data as $annee => $mois) {

                if (!isset($moisPayes[$annee])) {
                    $moisPayes[$annee] = [];
                }

                $moisPayes[$annee] = array_merge($moisPayes[$annee], $mois);
            }
        }
    }

    foreach ($moisPayes as $annee => $m) {
        $moisPayes[$annee] = array_unique($m);
    }

    // ✅ IMPORTANT : ajouter numero ici
    return Pdf::loadView('pdf.facture', compact(
        'famille',
        'date',
        'numero',
        'moisPayes'
    ))->stream('facture.pdf');
}
}
