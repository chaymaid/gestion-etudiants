<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quran extends Model
{
  protected $fillable = [
    'etudiant_id',
    'sourate',
    'hizb',
    'juz',
    'type',
    'note',
    'remarque',
    'date'

];

public function etudiant()
{
    return $this->belongsTo(Etudiant::class);
}
}
