@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">
<div class="card-header bg-success text-white text-center">
    <h4>➕ Ajouter un étudiant</h4>
</div>

<div class="card-body">

<form method="POST" enctype="multipart/form-data" action="{{ route('etudiants.store') }}">
@csrf

<!-- PHOTO -->
<div class="mb-3">
    <label>Photo</label>
    <input type="file" name="photo" class="form-control">
</div>

<!-- NOM -->
<div class="mb-3">
    <label>Nom complet</label>
    <input type="text" name="nom_complet" class="form-control" required>
</div>

<!-- TEL -->
<div class="mb-3">
    <label>Téléphone</label>
    <input type="text" name="telephone" class="form-control">
</div>

<!-- CLASSE -->
<div class="mb-3">
    <label>Classe</label>
    <select name="classe_id" class="form-control" required>
        @foreach($classes as $c)
            <option value="{{ $c->id }}">{{ $c->nom }}</option>
        @endforeach
    </select>
</div>

<!-- FRERES -->
<div class="mb-3">
    <label class="fw-bold">👨‍👩‍👧‍👦 Frères / Sœurs</label>

    <div class="border p-3 rounded" style="max-height:200px;overflow:auto;">
        @foreach($etudiants as $et)
            <div class="form-check">
                <input type="checkbox"
                       class="form-check-input frere-checkbox"
                       name="freres[]"
                       value="{{ $et->id }}"
                       data-nom="{{ $et->nom_complet }}">
                <label class="form-check-label">
                    {{ $et->nom_complet }}
                </label>
            </div>
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
    <input type="number" name="prix" id="prix" class="form-control" readonly>
</div>

<!-- 📅 MOIS PAYÉS -->
<div class="mb-3">
    <label class="fw-bold">📅 Mois payés</label>

    @php
        $mois = [
            'janvier','fevrier','mars','avril','mai','juin',
            'juillet','aout','septembre','octobre','novembre','decembre'
        ];
    @endphp

    <div class="row">
        @foreach($mois as $m)
            <div class="col-md-3">
                <div class="form-check">
                    <input type="checkbox"
                           name="mois_payes[]"
                           value="{{ $m }}"
                           class="form-check-input">

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
    <textarea name="emploi_temps" class="form-control"></textarea>
</div>

<button class="btn btn-success w-100">💾 Enregistrer</button>

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

<style>
.badge {
    padding: 6px 12px;
    border-radius: 20px;
}
</style>

@endsection
