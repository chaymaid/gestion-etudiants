@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <!-- HEADER -->
    <div class="card shadow-lg border-0 rounded-4 mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📋 Liste des inscriptions</h5>

            <a href="{{ route('inscriptions.create') }}" class="btn btn-light">
                ➕ Ajouter
            </a>
        </div>
    </div>

    <!-- 🔍 RECHERCHE -->
    <form method="GET" action="{{ route('inscriptions.index') }}" id="searchForm" class="mb-3">
        <div class="row g-2">

            <div class="col-md-6">
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="🔎 Rechercher un étudiant...">
            </div>

            <div class="col-md-2">
                <a href="{{ route('inscriptions.index') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>
    </form>

    <!-- ACCORDION -->
    <div class="accordion" id="accordionClasses">

        @foreach($classes as $classe)

        {{-- cacher classes vides si recherche --}}
        @if(!request('search') || $classe->inscriptions->count() > 0)

        <div class="accordion-item border-0 mb-3 shadow-sm rounded-4">

            <!-- HEADER -->
            <h2 class="accordion-header">
                <button class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#classe{{ $classe->id }}">

                    <div class="d-flex align-items-center gap-2">
                        📋✏️ <strong>{{ $classe->nom }}</strong>

                        <span class="badge bg-primary">
                            {{ $classe->inscriptions_count }}
                        </span>
                    </div>

                </button>
            </h2>

            <!-- BODY -->
            <div id="classe{{ $classe->id }}"
                 class="accordion-collapse collapse"
                 data-bs-parent="#accordionClasses">

                <div class="accordion-body p-0">

                    @if($classe->inscriptions->count() > 0)

                    <table class="table table-hover text-center mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>👤 Étudiant</th>
                                <th>📅 Date</th>
                                <th>⚙️ Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($classe->inscriptions as $i)
                            <tr>

                                <td class="fw-bold">
                                    {{ $i->etudiant->nom_complet }}
                                </td>

                                <td>{{ $i->date_inscription }}</td>

                                <td>

                                    <!-- EDIT -->
                                    <a href="{{ route('inscriptions.edit', $i->id) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏️
                                    </a>

                                    <!-- DELETE -->
                                    <form action="{{ route('inscriptions.destroy', $i->id) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Supprimer cette inscription ?')">
                                            🗑️
                                        </button>
                                    </form>

                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    @else

                    <div class="text-center p-3 text-muted">
                        ❌ Aucune inscription
                    </div>

                    @endif

                </div>

            </div>

        </div>

        @endif

        @endforeach

    </div>

</div>

<!-- ✅ JS DEBOUNCE -->
<script>
let timer;

document.getElementById('search').addEventListener('keyup', function () {
    clearTimeout(timer);

    timer = setTimeout(() => {
        document.getElementById('searchForm').submit();
    }, 500); // 500ms
});
</script>

@endsection
