@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">

    <div class="card-header bg-warning text-dark text-center">
        <h4>✏️ Modifier inscription</h4>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('inscriptions.update', $inscription->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Étudiant</label>
                <select name="etudiant_id" class="form-control rounded-3">
                    @foreach($etudiants as $e)
                        <option value="{{ $e->id }}"
                            {{ $e->id == $inscription->etudiant_id ? 'selected' : '' }}>
                            {{ $e->nom_complet }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Classe</label>
                <select name="classe_id" class="form-control rounded-3">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}"
                            {{ $c->id == $inscription->classe_id ? 'selected' : '' }}>
                            {{ $c->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Date d'inscription</label>
                <input type="date" name="date_inscription"
                       value="{{ $inscription->date_inscription }}"
                       class="form-control rounded-3">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('inscriptions.index') }}" class="btn btn-secondary">
                    ⬅ Retour
                </a>

                <button class="btn btn-warning">
                    <i class="bi bi-check-circle"></i> Modifier
                </button>
            </div>

        </form>

    </div>
</div>

</div>

@endsection
