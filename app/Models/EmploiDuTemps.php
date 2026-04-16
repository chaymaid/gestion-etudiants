<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploiDuTemps extends Model
{
    protected $table = 'emplois_du_temps';

    protected $fillable = [
        'classe_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'matiere',
        'professeur'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
