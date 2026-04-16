<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\EmploiDuTempsController;
/*
|--------------------------------------------------------------------------
| Redirection
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Routes protégées
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CRUD PRINCIPAL
    |--------------------------------------------------------------------------
    */
    Route::resource('etudiants', EtudiantController::class);
    Route::resource('classes', ClasseController::class);
    Route::resource('absences', AbsenceController::class);
    Route::resource('inscriptions', InscriptionController::class);
    Route::resource('matieres', MatiereController::class);
    Route::resource('quran', QuranController::class);

    /*
    |--------------------------------------------------------------------------
    | NOTES (CORRIGÉ 🔥)
    |--------------------------------------------------------------------------
    */

   /*
|--------------------------------------------------------------------------
| NOTES (PROPRE ✅)
|--------------------------------------------------------------------------
*/

// UNE SEULE FOIS
Route::resource('notes', NoteController::class)->except(['edit','update']);

// EDIT PAR MATIERE
Route::get('/notes/{etudiant}/edit-matiere/{matiere}',
    [NoteController::class, 'editMatiere']
)->name('notes.edit.matiere');

// UPDATE PAR MATIERE
Route::put('/notes/{etudiant}/update-matiere/{matiere}',
    [NoteController::class, 'updateMatiere']
)->name('notes.update.matiere');

// OPTIONNEL
Route::get('/notes/etudiant/{id}',
    [NoteController::class, 'notesParEtudiant']
)->name('notes.etudiant');

Route::get('/notes/{id}/pdf', [NoteController::class, 'pdf'])
    ->name('notes.pdf');


    Route::post('/etudiants/{id}/payer-mois', [EtudiantController::class, 'payerMois'])
    ->name('etudiants.payerMois');
    /*
    |--------------------------------------------------------------------------
    | AUTRES ACTIONS
    |--------------------------------------------------------------------------
    */

    Route::get('classes/{id}/matieres',
        [MatiereController::class, 'parClasse']
    )->name('classes.matieres');

    Route::post('/etudiants/{id}/toggle-paiement',
        [EtudiantController::class, 'togglePaiement']
    )->name('etudiants.togglePaiement');

    Route::post('/etudiants/{id}/payer',
        [EtudiantController::class, 'payer']
    )->name('etudiants.payer');
Route::get('/facture/{id}', [EtudiantController::class, 'factureFamille'])
    ->name('facture.famille');
Route::post('/etudiants/{id}/supprimer-mois', [EtudiantController::class, 'supprimerMois'])
    ->name('etudiants.supprimerMois');

// 🔄 Toggle mois
Route::post('/etudiants/{id}/toggle-mois', [EtudiantController::class, 'toggleMois'])
    ->name('etudiants.toggleMois');
Route::post('/etudiants/lier-freres', [EtudiantController::class, 'lierFreres'])
    ->name('etudiants.lierFreres');
// 👨‍👩‍👧‍👦 Toggle famille
Route::post('/etudiants/{id}/toggle-mois-famille', [EtudiantController::class, 'toggleMoisFamille'])
    ->name('etudiants.toggleMoisFamille');














Route::get('classes/{classe_id}/emplois', [EmploiDuTempsController::class, 'index'])
    ->name('emplois.index');

Route::get('classes/{classe_id}/emplois/create', [EmploiDuTempsController::class, 'create'])
    ->name('emplois.create');

Route::post('emplois/store', [EmploiDuTempsController::class, 'store'])
    ->name('emplois.store');

Route::get('emplois/{id}/edit', [EmploiDuTempsController::class, 'edit'])
    ->name('emplois.edit');

Route::put('emplois/{id}', [EmploiDuTempsController::class, 'update'])
    ->name('emplois.update');

Route::delete('emplois/{id}', [EmploiDuTempsController::class, 'destroy'])
    ->name('emplois.destroy');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
