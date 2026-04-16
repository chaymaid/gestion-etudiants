@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">

<!-- HEADER -->
<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    <h5>🎓 Liste des étudiants</h5>

    <a href="{{ route('etudiants.create') }}" class="btn btn-light">
        ➕ Ajouter
    </a>
</div>

<div class="card-body">

<!-- 🔍 RECHERCHE + ANNÉE -->
<form method="GET" class="row mb-4">

    <div class="col-md-4">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="🔍 Rechercher..."
               onkeyup="this.form.submit()">
    </div>

    <div class="col-md-3">
        <select name="annee" class="form-select" onchange="this.form.submit()">
            @for($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
                <option value="{{ $y }}" {{ request('annee', date('Y')) == $y ? 'selected' : '' }}>
                    📅 {{ $y }}
                </option>
            @endfor
        </select>
    </div>

</form>

@php
    $annee = request('annee', date('Y'));

    $allMois = [
        'janvier','fevrier','mars','avril','mai','juin',
        'juillet','aout','septembre','octobre','novembre','decembre'
    ];
@endphp

<!-- ACCORDION -->
<div class="accordion" id="classesAccordion">

@foreach($classes as $classe)

<div class="accordion-item mb-3 shadow-sm">

<h2 class="accordion-header">
<button class="accordion-button collapsed fw-bold"
        data-bs-toggle="collapse"
        data-bs-target="#c{{ $classe->id }}">

📚 {{ $classe->nom }}
<span class="badge bg-primary ms-2">{{ $classe->etudiants->count() }}</span>

</button>
</h2>

<div id="c{{ $classe->id }}" class="accordion-collapse collapse">

<div class="accordion-body p-0">

@if($classe->etudiants->count())

<table class="table table-hover align-middle text-center mb-0">

<thead class="table-dark">
<tr>
<th>📷</th>
<th>Nom</th>
<th>📞 Téléphone</th>
<th>👨‍👩‍👧 Frères</th>
<th>💰 Prix</th>
<th>📊 Progression</th>
<th>📅 Reste à payer</th>
<th>⚙️</th>
</tr>
</thead>

<tbody>

@foreach($classe->etudiants as $e)

@php
    $data = $e->mois_payes;

    // 🔥 CORRECTION IMPORTANTE
    if (is_string($data)) {
        $data = json_decode($data, true);
    }

    if (!is_array($data)) {
        $data = [];
    }

    $payes = $data[$annee] ?? [];

    $paye = count($payes);
    $pourcentage = ($paye / 12) * 100;
@endphp

<tr>

<!-- PHOTO -->
<td>
@if($e->photo)
<img src="{{ asset('storage/'.$e->photo) }}" width="45" class="rounded-circle shadow-sm">
@else
-
@endif
</td>

<!-- NOM -->
<td class="fw-bold">{{ $e->nom_complet }}</td>

<!-- TEL -->
<td>{{ $e->telephone ?? '-' }}</td>

<!-- FRERES -->
<td>
@if($e->famille_id && $e->freres->count())
    @foreach($e->freres as $fr)
        <span class="badge bg-secondary me-1">{{ $fr->nom_complet }}</span>
    @endforeach
@else
    <span class="text-muted">-</span>
@endif
</td>

<!-- PRIX -->
<td class="text-success fw-bold">{{ $e->prix }} DH</td>

<!-- 🔥 PROGRESSION (BARRE) -->
<td style="min-width:150px">
    <div class="progress" style="height: 20px;">
        <div class="progress-bar bg-success"
             style="width: {{ $pourcentage }}%">
            {{ $paye }}/12
        </div>
    </div>
</td>

<!-- 🔴 MOIS NON PAYÉS -->
<td style="min-width:250px">

@php $count = 0; @endphp

@foreach($allMois as $m)

    @if(!in_array($m, $payes))

        @php $count++; @endphp

        @if($count <= 6) {{-- 🔥 limiter affichage --}}

        <form action="{{ route('etudiants.payerMois', $e->id) }}"
              method="POST"
              style="display:inline;">
            @csrf

            <input type="hidden" name="mois" value="{{ $m }}">
            <input type="hidden" name="annee" value="{{ $annee }}">

            <button class="badge bg-danger border-0 me-1 mb-1">
                💰 {{ ucfirst($m) }}
            </button>
        </form>

        @endif

    @endif

@endforeach

@if($count > 6)
    <span class="badge bg-secondary">+{{ $count - 6 }}</span>
@endif

</td>

<!-- ACTIONS -->
<td>

<a href="{{ route('etudiants.edit', $e->id) }}"
   class="btn btn-warning btn-sm">✏️</a>

<a href="{{ route('etudiants.show', $e->id) }}"
   class="btn btn-info btn-sm">👁️</a>

<form action="{{ route('etudiants.destroy', $e->id) }}"
      method="POST"
      style="display:inline;">
@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
        onclick="return confirm('Supprimer ?')">
    🗑️
</button>
</form>

</td>

</tr>

@endforeach

</tbody>
</table>

@else

<div class="p-3 text-center text-muted">
Aucun étudiant
</div>

@endif

</div>
</div>

</div>

@endforeach

</div>

</div>
</div>
</div>

@endsection
