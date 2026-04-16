<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{

protected $fillable = [
    'nom_complet',
    'telephone',
    'classe_id',
    'emploi_temps',
    'prix',
    'photo',
    'famille_id',
    'mois_payes',
];

protected $casts = [
    'mois_payes' => 'array'
];


// RELATIONS
public function classe()
{
    return $this->belongsTo(\App\Models\Classe::class);
}

public function notes()
{
    return $this->hasMany(\App\Models\Note::class);
}

public function absences()
{
    return $this->hasMany(\App\Models\Absence::class);
}

public function inscriptions()
{
    return $this->hasMany(Inscription::class);
}

public function freres()
{
    return $this->hasMany(Etudiant::class, 'famille_id', 'famille_id')
        ->where('id', '!=', $this->id);
}

public function qurans()
{
    return $this->hasMany(Quran::class);
}

}
