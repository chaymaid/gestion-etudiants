@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg">

    <div class="card-header bg-success text-white">
        ➕ Ajouter une matière
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('matieres.store') }}">
            @csrf

            <input type="text" name="nom" class="form-control mb-3" placeholder="Nom matière">

            <select name="classe_id" class="form-control mb-3">
                @foreach($classes as $c)
                    <option value="{{ $c->id }}">{{ $c->nom }}</option>
                @endforeach
            </select>

            <button class="btn btn-success">💾 Enregistrer</button>

        </form>

    </div>

</div>

</div>

@endsection
