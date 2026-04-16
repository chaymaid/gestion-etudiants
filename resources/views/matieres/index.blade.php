@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0">📚 Liste des matières</h5>

            <a href="{{ route('matieres.create') }}" class="btn btn-light">
                ➕ Ajouter
            </a>
        </div>

        <!-- BODY -->
        <div class="card-body">

            <div class="accordion" id="accordionMatieres">

                @forelse($matieres as $classeNom => $listeMatieres)

                <div class="accordion-item mb-3 border-0 shadow-sm rounded-3">

                    <!-- HEADER CLASSE -->
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#classe{{ md5($classeNom) }}">

                            📚 {{ $classeNom }}

                            <span class="badge bg-primary ms-3">
                                {{ count($listeMatieres) }}
                            </span>

                        </button>
                    </h2>

                    <!-- CONTENU -->
                    <div id="classe{{ md5($classeNom) }}"
                         class="accordion-collapse collapse"
                         data-bs-parent="#accordionMatieres">

                        <div class="accordion-body p-0">

                            <table class="table table-hover align-middle text-center mb-0">

                                <thead class="table-dark">
                                    <tr>
                                        <th>Matière</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($listeMatieres as $m)
                                    <tr>

                                        <td class="fw-bold">
                                            {{ $m->nom }}
                                        </td>

                                        <td>

                                            <!-- EDIT -->
                                            <a href="{{ route('matieres.edit', $m->id) }}"
                                               class="btn btn-warning btn-sm me-1 rounded-circle">
                                                ✏️
                                            </a>

                                            <!-- DELETE -->
                                            <form action="{{ route('matieres.destroy', $m->id) }}"
                                                  method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm rounded-circle"
                                                        onclick="return confirm('Supprimer cette matière ?')">
                                                    🗑️
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>
                    </div>

                </div>

                @empty

                <div class="text-center text-muted p-4">
                    Aucune matière trouvée
                </div>

                @endforelse

            </div>

        </div>
    </div>

</div>

@endsection
