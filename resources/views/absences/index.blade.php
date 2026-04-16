@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📋 Liste des absences</h5>

            <a href="{{ route('absences.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Ajouter
            </a>
        </div>

        <!-- FILTRES -->
        <div class="p-3 border-bottom">

            <form method="GET" action="{{ route('absences.index') }}">
                <div class="row g-2">

                    <div class="col-md-6">
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="🔍 Étudiant..."
                               onkeyup="this.form.submit()">
                    </div>

                    <div class="col-md-4">
                        <input type="date" name="date"
                               value="{{ request('date') }}"
                               class="form-control"
                               onchange="this.form.submit()">
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('absences.index') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>

                </div>
            </form>

        </div>

        <!-- BODY -->
        <div class="card-body">

            @php
                $hasFilter = request('search') || request('date');
            @endphp

            @foreach($classes as $classe)

                @php
                    $hasData = false;

                    foreach($classe->etudiants as $e){
                        if($e->absences->count() > 0){
                            $hasData = true;
                            break;
                        }
                    }
                @endphp

                @if(!$hasFilter || $hasData)

                <div class="mb-3 border rounded-4 overflow-hidden shadow-sm">

                    <!-- HEADER CLASSE -->
                    <div class="bg-light p-3 d-flex justify-content-between align-items-center"
                         style="cursor:pointer"
                         onclick="toggleClasse({{ $classe->id }})">

                        <div class="fw-bold">
                            📚 {{ $classe->nom }}
                        </div>

                        <span class="badge bg-danger">
                            {{ $classe->etudiants->sum(fn($e) => $e->absences->count()) }} absences
                        </span>
                    </div>

                    <!-- TABLE -->
                    <div id="classe-{{ $classe->id }}" style="display:none">

                        <table class="table table-hover align-middle text-center mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th>👤 Étudiant</th>
                                    <th>📊 Absences</th>
                                    <th>📅 Détails</th>
                                    <th>⚙️ Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($classe->etudiants as $etudiant)

                                    @php
                                        $absences = $etudiant->absences;
                                        $count = $absences->count();

                                        // 📱 Nettoyage + conversion 06 → 212
                                        $phone = preg_replace('/[^0-9]/', '', $etudiant->telephone);

                                        if($phone && str_starts_with($phone, '0')){
                                            $phone = '212' . substr($phone, 1);
                                        }

                                        $message = "Bonjour, votre enfant ".$etudiant->nom_complet." a ".$count." absences. Merci de contacter l'école.";
                                    @endphp

                                    @if(!$hasFilter || $count > 0)

                                    <tr style="{{ $count >= 4 ? 'background-color:#f8d7da;' : '' }}">

                                        <!-- ETUDIANT -->
                                        <td class="fw-bold">
                                            {{ $etudiant->nom_complet }}
                                        </td>

                                        <!-- NOMBRE -->
                                        <td>
                                            <span class="badge {{ $count >= 4 ? 'bg-danger' : 'bg-dark' }}">
                                                {{ $count }}
                                            </span>

                                            @if($count >= 4)
                                                <div class="text-danger small mt-1">
                                                    📞 Appeler les parents
                                                </div>
                                            @endif
                                        </td>

                                        <!-- DETAILS -->
                                        <td class="text-start">

                                            @foreach($absences as $a)
                                                <div>
                                                    📅 {{ $a->date }}
                                                    <span class="badge bg-warning text-dark">
                                                        {{ $a->motif }}
                                                    </span>
                                                </div>
                                            @endforeach

                                            @if($count >= 4)
                                                <div class="alert alert-danger mt-2 p-2">
                                                    ⚠️ Cet étudiant a atteint 4 absences ou plus.
                                                </div>
                                            @endif

                                        </td>

                                        <!-- ACTIONS -->
                                        <td>

                                            <!-- EDIT -->
                                            <a href="{{ route('etudiants.edit', $etudiant->id) }}"
                                               class="btn btn-warning btn-sm me-1">
                                                ✏️
                                            </a>

                                            <!-- DELETE -->
                                            <form action="{{ route('etudiants.destroy', $etudiant->id) }}"
                                                  method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm">
                                                    🗑️
                                                </button>
                                            </form>

                                            <!-- 📱 WHATSAPP -->
                                            @if($count >= 4 && $phone)
                                                <a href="https://api.whatsapp.com/send?phone={{ $phone }}&text={{ urlencode($message) }}"
                                                   target="_blank"
                                                   class="btn btn-success btn-sm mt-1">
                                                   📱 WhatsApp
                                                </a>
                                            @endif

                                        </td>

                                    </tr>

                                    @endif

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                @endif

            @endforeach

        </div>

    </div>

</div>

<!-- SCRIPT -->
<script>
function toggleClasse(id){
    let el = document.getElementById('classe-' + id);
    el.style.display = (el.style.display === 'none') ? 'block' : 'none';
}
</script>

@endsection
