<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Matiere;

class Classe extends Model
{
    protected $fillable = ['nom'];

    // 🎓 Étudiants de la classe
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    // 📝 Inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // 📚 Matières
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
}
