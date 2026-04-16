@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">

<!-- HEADER -->
<div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
    <h4 class="mb-0">👁️ Détails étudiant</h4>

    <a href="{{ route('facture.famille', $etudiant->id) }}"
       class="btn btn-dark btn-sm">
        🧾 Facture
    </a>
</div>

<div class="card-body">

<!-- INFOS -->
<div class="text-center mb-4">
    <h3 class="fw-bold">{{ $etudiant->nom_complet }}</h3>
    <p class="text-muted">{{ $etudiant->telephone ?? '' }}</p>
</div>

@php
    $ordre = [
        'janvier','fevrier','mars','avril','mai','juin',
        'juillet','aout','septembre','octobre','novembre','decembre'
    ];

    $data = $etudiant->mois_payes;

    if (is_string($data)) {
        $data = json_decode($data, true);
    }

    if (!is_array($data)) {
        $data = [];
    }
@endphp

@forelse($data as $annee => $mois)

    @php
        usort($mois, function($a, $b) use ($ordre) {
            return array_search($a, $ordre) - array_search($b, $ordre);
        });
    @endphp

    <div class="mb-4">

        <h5 class="text-primary mb-3">📅 {{ $annee }}</h5>

        <div class="d-flex flex-wrap justify-content-center">

        @foreach($mois as $m)

        <form action="{{ route('etudiants.supprimerMois', $etudiant->id) }}"
              method="POST"
              class="me-2 mb-2">
            @csrf

            <input type="hidden" name="mois" value="{{ $m }}">
            <input type="hidden" name="annee" value="{{ $annee }}">

            <button class="badge bg-success border-0 px-3 py-2">
                ✔ {{ ucfirst($m) }} ❌
            </button>

        </form>

        @endforeach

        </div>
    </div>

@empty

    <div class="text-center text-muted">
        Aucun paiement enregistré
    </div>

@endforelse

</div>

</div>
</div>

@endsection
