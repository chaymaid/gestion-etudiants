@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card p-4 shadow">

<h5>✏️ Modifier cours</h5>

<form method="POST" action="{{ route('emplois.update', $emploi->id) }}">
@csrf
@method('PUT')

<select name="jour" class="form-control mb-2">
    @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j)
        <option value="{{ $j }}" {{ $emploi->jour == $j ? 'selected' : '' }}>
            {{ $j }}
        </option>
    @endforeach
</select>

<input type="time" name="heure_debut" value="{{ $emploi->heure_debut }}" class="form-control mb-2">
<input type="time" name="heure_fin" value="{{ $emploi->heure_fin }}" class="form-control mb-2">

<input type="text" name="matiere" value="{{ $emploi->matiere }}" class="form-control mb-2">
<input type="text" name="professeur" value="{{ $emploi->professeur }}" class="form-control mb-2">

<button class="btn btn-primary">Modifier</button>

</form>

</div>
</div>

@endsection
