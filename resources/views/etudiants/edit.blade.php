@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">
<div class="card-header bg-warning text-dark text-center">
    <h4>✏️ Modifier étudiant</h4>
</div>

<div class="card-body">

<form method="POST" enctype="multipart/form-data" action="{{ route('etudiants.update',$etudiant->id) }}">
@csrf
@method('PUT')

@php
    $data = $etudiant->mois_payes;

    if (is_string($data)) {
        $data = json_decode($data, true);
    }

    if (!is_array($data)) {
        $data = [];
    }

    $annee = request('annee', date('Y'));
    $payes = $data[$annee] ?? [];

    $mois = [
        'janvier','fevrier','mars','avril','mai','juin',
        'juillet','aout','septembre','octobre','novembre','decembre'
    ];
@endphp

<!-- PHOTO -->
<div class="mb-3">
    <label>Photo</label>
    <input type="file" name="photo" class="form-control">

    @if($etudiant->photo)
        <img src="{{ asset('storage/'.$etudiant->photo) }}" width="80" class="mt-2 rounded">
    @endif
</div>

<!-- NOM -->
<div class="mb-3">
    <label>Nom complet</label>
    <input type="text" name="nom_complet"
           value="{{ $etudiant->nom_complet }}"
           class="form-control" required>
</div>

<!-- TELEPHONE -->
<div class="mb-3">
    <label>Téléphone</label>
    <input type="text" name="telephone"
           value="{{ $etudiant->telephone }}"
           class="form-control">
</div>

<!-- CLASSE -->
<div class="mb-3">
    <label>Classe</label>
    <select name="classe_id" class="form-control" required>
        @foreach($classes as $c)
            <option value="{{ $c->id }}"
            {{ $etudiant->classe_id == $c->id ? 'selected' : '' }}>
            {{ $c->nom }}
            </option>
        @endforeach
    </select>
</div>

<!-- FRERES -->
<div class="mb-3">
    <label class="fw-bold">👨‍👩‍👧‍👦 Frères / Sœurs</label>

    <div class="border p-3 rounded" style="max-height:200px;overflow:auto;">
        @foreach($etudiants as $et)
            @if($et->id != $etudiant->id)
            <div class="form-check">
                <input type="checkbox"
                       class="form-check-input frere-checkbox"
                       name="freres[]"
                       value="{{ $et->id }}"
                       data-nom="{{ $et->nom_complet }}"
                       {{ in_array($et->id, $freres_ids ?? []) ? 'checked' : '' }}>

                <label class="form-check-label">
                    {{ $et->nom_complet }}
                </label>
            </div>
            @endif
        @endforeach
    </div>

    <div class="mt-3">
        <strong>🎯 Sélection :</strong>
        <div id="badges-container"></div>
    </div>
</div>

<!-- PRIX -->
<div class="mb-3">
    <label>Prix</label>
    <input type="number" name="prix"
           value="{{ $etudiant->prix }}"
           id="prix"
           class="form-control" readonly>
</div>

<!-- ANNEE -->
<div class="mb-3">
    <label>Année</label>
    <select name="annee" class="form-control">
        @for($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
            <option value="{{ $y }}" {{ $annee == $y ? 'selected' : '' }}>
                {{ $y }}
            </option>
        @endfor
    </select>
</div>

<!-- MOIS PAYES -->
<div class="mb-3">
    <label class="fw-bold">📅 Mois payés</label>

    <div class="row">
        @foreach($mois as $m)
            <div class="col-md-3">
                <div class="form-check">
                    <input type="checkbox"
                           name="mois_payes[]"
                           value="{{ $m }}"
                           class="form-check-input"
                           {{ in_array($m, $payes) ? 'checked' : '' }}>

                    <label class="form-check-label">
                        {{ ucfirst($m) }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- EMPLOI -->
<div class="mb-3">
    <label>Emploi du temps</label>
    <textarea name="emploi_temps" class="form-control">{{ $etudiant->emploi_temps }}</textarea>
</div>

<button class="btn btn-warning w-100">✔ Modifier</button>

</form>

</div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const checkboxes = document.querySelectorAll('.frere-checkbox');
    const container = document.getElementById('badges-container');
    const prixInput = document.getElementById('prix');

    function updateUI() {

        container.innerHTML = '';
        let count = 1;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                count++;

                let badge = document.createElement('span');
                badge.className = 'badge bg-primary me-2 mb-2';
                badge.innerText = cb.dataset.nom;

                container.appendChild(badge);
            }
        });

        let prix = 80;
        if (count == 2) prix = 100;
        else if (count >= 3) prix = 130;

        prixInput.value = prix;
    }

    updateUI();

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateUI);
    });

});
</script>

@endsection
