@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">

    <div class="card-header bg-success text-white text-center">
        <h4>➕ Ajouter une absence</h4>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('absences.store') }}">
            @csrf

            <div class="mb-3">
                <label>Étudiant</label>
                <select name="etudiant_id" class="form-control rounded-3">
                    @foreach($etudiants as $e)
                        <option value="{{ $e->id }}">{{ $e->nom_complet }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="date" class="form-control rounded-3">
            </div>

            <div class="mb-3">
                <label>Motif</label>
                <input type="text" name="motif" class="form-control rounded-3">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('absences.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>

                <button class="btn btn-success">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </div>

        </form>

    </div>
</div>

</div>

@endsection
