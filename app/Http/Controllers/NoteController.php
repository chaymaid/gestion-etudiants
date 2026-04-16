<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Etudiant;
use App\Models\Classe;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NoteController extends Controller
{
    // 📊 LISTE (OPTIMISÉ)
    public function index()
    {
        $classes = Classe::with([
            'matieres', // 🔥 IMPORTANT (pour éviter répétition)
            'etudiants.notes' // 🔥 notes seulement (plus rapide)
        ])->get();

        return view('notes.index', compact('classes'));
    }

    // ➕ CREATE
    public function create()
    {
        $etudiants = Etudiant::with('classe.matieres')->get();
        return view('notes.create', compact('etudiants'));
    }

    // 💾 STORE MULTI EXAMS
    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'matiere_id'  => 'required|exists:matieres,id',
            'notes'       => 'required|array'
        ]);

        foreach ($request->notes as $type => $note) {

            // ignorer champs vides
            if ($note === null || $note === '') continue;

            Note::updateOrCreate(
                [
                    'etudiant_id' => $request->etudiant_id,
                    'matiere_id'  => $request->matiere_id,
                    'type_exam'   => $type,
                ],
                [
                    'note' => $note
                ]
            );
        }

        return redirect()->route('notes.index')
            ->with('success', 'Notes ajoutées avec succès');
    }

    // ✏️ EDIT PAR MATIERE
    public function editMatiere($etudiant_id, $matiere_id)
    {
        $etudiant = Etudiant::with('classe.matieres')->findOrFail($etudiant_id);

        $notes = Note::where('etudiant_id', $etudiant_id)
            ->where('matiere_id', $matiere_id)
            ->get()
            ->keyBy('type_exam'); // 🔥 clé = Exam 1,2...

        return view('notes.edit', compact('etudiant', 'matiere_id', 'notes'));
    }

    // 🔄 UPDATE MULTI EXAMS
    public function updateMatiere(Request $request, $etudiant_id, $matiere_id)
    {
        $request->validate([
            'notes' => 'required|array'
        ]);

        foreach ($request->notes as $type => $note) {

            if ($note === null || $note === '') continue;

            Note::updateOrCreate(
                [
                    'etudiant_id' => $etudiant_id,
                    'matiere_id'  => $matiere_id,
                    'type_exam'   => $type,
                ],
                [
                    'note' => $note
                ]
            );
        }

        return redirect()->route('notes.index')
            ->with('success', 'Notes modifiées avec succès');
    }

    // ❌ DELETE (UNE NOTE)
    public function destroy($id)
    {
        Note::findOrFail($id)->delete();

        return back()->with('success', 'Note supprimée');
    }

    // ❌ DELETE PAR MATIERE (OPTION BONUS 🔥)
    public function destroyMatiere($etudiant_id, $matiere_id)
    {
        Note::where('etudiant_id', $etudiant_id)
            ->where('matiere_id', $matiere_id)
            ->delete();

        return back()->with('success', 'Toutes les notes supprimées');
    }

    // 👁 SHOW
    public function show($id)
    {
        $etudiant = Etudiant::with([
            'classe',
            'notes.matiere'
        ])->findOrFail($id);

        return view('notes.show', compact('etudiant'));
    }
    public function pdf($id)
{
    $etudiant = Etudiant::with([
        'classe',
        'notes.matiere'
    ])->findOrFail($id);

    $pdf = Pdf::loadView('notes.pdf', compact('etudiant'));

    return $pdf->download('notes_'.$etudiant->nom_complet.'.pdf');
}
public function pdfClasse($id)
{
    $classe = Classe::with([
        'etudiants.notes.matiere'
    ])->findOrFail($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('notes.pdf_classe', compact('classe'));

    return $pdf->download('classe_'.$classe->nom.'.pdf');
}

}
