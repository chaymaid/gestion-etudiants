<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = ['etudiant_id', 'date', 'motif'];

public function etudiant()
{
    return $this->belongsTo(\App\Models\Etudiant::class);
}
}
