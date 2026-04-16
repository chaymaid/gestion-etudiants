<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // ✅ IMPORTANT
use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Note;
use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $annee = $request->annee ?? date('Y');
        $date  = $request->date;

        // 🔢 COUNTS
        $etudiants = Etudiant::count();
        $classes   = Classe::count();
        $notes     = Note::count();
        $absences  = Absence::count();

        // 📈 INSCRIPTIONS
        $inscriptionsQuery = DB::table('inscriptions')
            ->whereYear('date_inscription', $annee);

        if ($date) {
            $inscriptionsQuery->whereDate('date_inscription', $date);
        }

        $inscriptions = $inscriptionsQuery
            ->selectRaw('MONTH(date_inscription) as mois, COUNT(*) as total')
            ->groupBy('mois')
            ->pluck('total', 'mois')
            ->toArray();

        // 📉 ABSENCES
        $absencesQuery = Absence::whereYear('date', $annee);

        if ($date) {
            $absencesQuery->whereDate('date', $date);
        }

        $absencesData = $absencesQuery
            ->selectRaw('MONTH(date) as mois, COUNT(*) as total')
            ->groupBy('mois')
            ->pluck('total', 'mois')
            ->toArray();

        // 📊 CLASSES
        $classesData = Classe::withCount('etudiants')->get();
        $labelsClasses = $classesData->pluck('nom');
        $dataClasses   = $classesData->pluck('etudiants_count');

        // 🥧 NOTES
        $notesData = Note::whereYear('created_at', $annee)
            ->select('matiere_id', DB::raw('AVG(note) as moyenne'))
            ->with('matiere')
            ->groupBy('matiere_id')
            ->get();

        $matieres = $notesData->map(fn($n) => $n->matiere->nom ?? '---');
        $moyennes = $notesData->pluck('moyenne')->map(fn($m) => round($m,2));

        // 💰 PAIEMENTS (CORRIGÉ)
        $paiements = [];
        $allMois = [
            'janvier','fevrier','mars','avril','mai','juin',
            'juillet','aout','septembre','octobre','novembre','decembre'
        ];

        foreach (Etudiant::all() as $e) {

            $moisPayes = is_array($e->mois_payes)
                ? ($e->mois_payes[$annee] ?? [])
                : [];

            foreach ($moisPayes as $m) {

                $index = array_search($m, $allMois);

                if ($index !== false) {
                    $index++; // mois 1 → 12

                    if (!isset($paiements[$index])) {
                        $paiements[$index] = 0;
                    }

                    $paiements[$index]++;
                }
            }
        }

        // ✅ RETURN À LA FIN
        return view('dashboard', compact(
            'etudiants',
            'classes',
            'notes',
            'absences',
            'inscriptions',
            'absencesData',
            'labelsClasses',
            'dataClasses',
            'matieres',
            'moyennes',
            'paiements' // ✅ AJOUTÉ
        ));
    }
}
