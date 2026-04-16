@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">

    <div class="card-header bg-success text-white text-center">
        <h4>➕ Ajouter une inscription</h4>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('inscriptions.store') }}">
            @csrf

            <!-- ETUDIANT -->
            <div class="mb-3">
                <label class="form-label">Étudiant</label>
                <select id="etudiant" name="etudiant_id" class="form-control rounded-3">
                    <option value="">-- Choisir --</option>
                    @foreach($etudiants as $e)
                        <option value="{{ $e->id }}" data-classe="{{ $e->classe_id }}">
                            {{ $e->nom_complet }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- CLASSE -->
            <div class="mb-3">
                <label class="form-label">Classe</label>
                <select id="classe" name="classe_id" class="form-control rounded-3">
                    <option value="">-- Auto --</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- DATE -->
            <div class="mb-3">
                <label class="form-label">Date d'inscription</label>
                <input type="date" name="date_inscription" class="form-control rounded-3" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('inscriptions.index') }}" class="btn btn-secondary">
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

<script>
document.getElementById('etudiant').addEventListener('change', function() {
    let classeId = this.options[this.selectedIndex].getAttribute('data-classe');
    if (classeId) {
        document.getElementById('classe').value = classeId;
    }
});
</script>

@endsection
