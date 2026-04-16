@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-sm border-0 rounded-4">

    <!-- HEADER -->
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5>📝 Liste des notes</h5>

        <a href="{{ route('notes.create') }}" class="btn btn-dark">
            ➕ Ajouter
        </a>
    </div>

    <div class="card-body">

    @foreach($classes as $classe)

        <div class="mb-4 border rounded-4 shadow-sm">

            <!-- HEADER CLASSE -->
            <div class="bg-secondary text-white p-3 rounded-4 d-flex justify-content-between"
                 style="cursor:pointer"
                 onclick="toggleClasse({{ $classe->id }})">

                <strong>📚 {{ $classe->nom }}</strong>

                <span class="badge bg-light text-dark">
                    {{ $classe->etudiants->count() }}
                </span>
            </div>

            <!-- CONTENT -->
            <div id="classe-{{ $classe->id }}" style="display:none;" class="p-3 bg-light rounded-bottom">

                @php
                    $matieres = $classe->matieres;
                    $exams = ['Exam 1','Exam 2','Exam 3','Exam 4'];
                @endphp

                <div style="overflow-x:auto">

                <table class="table table-bordered text-center align-middle">

                    <!-- HEADER -->
                    <thead class="table-dark">
                        <tr>
                            <th>👤 Étudiant</th>

                            @foreach($matieres as $matiere)
                                <th>{{ $matiere->nom }}</th>
                            @endforeach

                            <th>📊 Moyenne</th>
                            <th>⚙️</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($classe->etudiants as $etudiant)

                        @php
                            $notes = $etudiant->notes;
                        @endphp

                        <!-- LIGNE ETUDIANT -->
                        <tr>

                            <!-- NOM -->
                            <td class="fw-bold text-start">
                                {{ $etudiant->nom_complet }}
                            </td>

                            <!-- MATIERES (CLICKABLE) -->
                            @foreach($matieres as $matiere)

                                <td style="cursor:pointer"
                                    onclick="toggleMatiere('{{ $etudiant->id }}-{{ $matiere->id }}')">

                                    📚
                                </td>

                            @endforeach

                            <!-- MOYENNE -->
                            @php
                                $moyenne = $notes->count()
                                    ? round($notes->avg('note'), 2)
                                    : 0;
                            @endphp

                            <td>
                                <span class="badge bg-primary">
                                    {{ $moyenne }}
                                </span>
                            </td>

                            <!-- ACTIONS -->
                            <td>

                                <a href="{{ route('notes.show', $etudiant->id) }}"
                                   class="btn btn-sm btn-outline-dark">
                                    👁
                                </a>

                            </td>

                        </tr>

                        <!-- ROW EXAMS -->
                        <tr id="row-{{ $etudiant->id }}" style="display:none;">
                            <td colspan="{{ count($matieres)+2 }}" class="bg-white">

                                @foreach($matieres as $matiere)

                                    @php
                                        $notesMatiere = $notes->where('matiere_id', $matiere->id);
                                    @endphp

                                    <div id="matiere-{{ $etudiant->id }}-{{ $matiere->id }}"
                                         style="display:none"
                                         class="mb-3 border p-2 rounded">

                                        <!-- HEADER MATIERE -->
                                        <div class="d-flex justify-content-between align-items-center">

                                            <strong class="text-primary">
                                                📚 {{ $matiere->nom }}
                                            </strong>

                                            <!-- ACTIONS -->
                                            <div>

                                                <a href="{{ route('notes.edit.matiere', [$etudiant->id, $matiere->id]) }}"
                                                   class="btn btn-sm btn-outline-warning">
                                                    ✏️
                                                </a>

                                                @if($notesMatiere->first())
                                                <form action="{{ route('notes.destroy', $notesMatiere->first()->id) }}"
                                                      method="POST"
                                                      style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Supprimer ?')">
                                                        🗑
                                                    </button>
                                                </form>
                                                @endif

                                            </div>

                                        </div>

                                        <!-- EXAMS -->
                                        @foreach($exams as $exam)

                                            @php
                                                $note = $notesMatiere->firstWhere('type_exam', $exam);
                                            @endphp

                                            <div class="d-flex justify-content-between border-bottom py-1">

                                                <span>{{ $exam }}</span>

                                                @if($note)
                                                    <span class="badge bg-success">
                                                        {{ $note->note }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                @endforeach

                            </td>
                        </tr>

                    @endforeach

                    </tbody>

                </table>

                </div>

            </div>
        </div>

    @endforeach

    </div>
</div>

</div>

<!-- SCRIPT -->
<script>

function toggleClasse(id){
    let el = document.getElementById('classe-'+id);
    el.style.display = (el.style.display === 'none') ? 'block' : 'none';
}

function toggleMatiere(key){

    let [etudiant, matiere] = key.split('-');

    let row = document.getElementById('row-'+etudiant);
    let matiereDiv = document.getElementById('matiere-'+key);

    // afficher ligne globale
    row.style.display = (row.style.display === 'none') ? 'table-row' : row.style.display;

    // toggle matiere
    matiereDiv.style.display =
        (matiereDiv.style.display === 'none') ? 'block' : 'none';

}

</script>

@endsection
