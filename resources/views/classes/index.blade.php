@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0">🏫 Liste des classes</h5>

            <a href="{{ route('classes.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Ajouter
            </a>
        </div>

        <!-- BODY -->
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>📚 Nom</th>
                            <th>👨‍🎓 Étudiants</th>
                            <th>⚙️ Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($classes as $c)
                        <tr>

                            <!-- NOM -->
                            <td class="fw-bold">
                                {{ $c->nom }}
                            </td>

                            <!-- NOMBRE ETUDIANTS -->
                            <td>
                                <span class="badge bg-success">
                                    {{ $c->etudiants_count }}
                                </span>
                            </td>

                            <!-- ACTIONS -->
                            <td>
                                <!-- 📅 EMPLOI DU TEMPS -->
<a href="{{ route('emplois.index', $c->id) }}"
   class="btn btn-dark btn-sm me-1"
   title="Emploi du temps">
   📅
</a>

                                <!-- 👨‍🎓 VOIR INSCRIPTIONS -->
                                <a href="{{ route('inscriptions.index', ['classe_id' => $c->id]) }}"
                                   class="btn btn-primary btn-sm me-1"
                                   title="Voir inscriptions">
                                   👨‍🎓
                                </a>

                                <!-- ➕ AJOUT MATIERE -->
                                <a href="{{ route('matieres.create', ['classe_id' => $c->id]) }}"
                                   class="btn btn-success btn-sm me-1"
                                   title="Ajouter matière">
                                    ➕📚
                                </a>

                                <!-- 📚 VOIR MATIERES -->
                                <a href="{{ route('classes.matieres', $c->id) }}"
                                   class="btn btn-info btn-sm me-1"
                                   title="Voir matières">
                                    📚
                                </a>

                                <!-- ✏️ EDIT -->
                                <a href="{{ route('classes.edit', $c->id) }}"
                                   class="btn btn-warning btn-sm me-1">
                                    ✏️
                                </a>

                                <!-- 🗑️ DELETE -->
                                <form action="{{ route('classes.destroy', $c->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Supprimer cette classe ?')">
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

</div>

@endsection
