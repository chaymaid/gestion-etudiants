@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card p-4 shadow">

<h5>➕ Ajouter un cours ({{ $classe->nom }})</h5>

<form method="POST" action="{{ route('emplois.store') }}">
@csrf

<input type="hidden" name="classe_id" value="{{ $classe->id }}">

<select name="jour" class="form-control mb-2">
    <option>Lundi</option>
    <option>Mardi</option>
    <option>Mercredi</option>
    <option>Jeudi</option>
    <option>Vendredi</option>
    <option>Samedi</option>
</select>

<input type="time" name="heure_debut" class="form-control mb-2">
<input type="time" name="heure_fin" class="form-control mb-2">

<input type="text" name="matiere" class="form-control mb-2" placeholder="Matière">
<input type="text" name="professeur" class="form-control mb-2" placeholder="Professeur">

<button class="btn btn-success">Enregistrer</button>

</form>

</div>
</div>

@endsection
