@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">

    <!-- HEADER -->
    <div class="card-header bg-info text-white text-center">
        <h4>👁 Détails des notes</h4>
    </div>

    <div class="card-body">

        <!-- INFOS ETUDIANT -->
        <div class="mb-4 text-center">
            <h5 class="fw-bold">
                👤 {{ $etudiant->nom_complet }}
            </h5>

            <span class="badge bg-dark">
                📚 {{ $etudiant->classe->nom }}
            </span>
        </div>

        @php
            $grouped = $etudiant->notes->groupBy('matiere_id');
            $exams = ['Exam 1','Exam 2','Exam 3','Exam 4'];
        @endphp

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover text-center align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>📚 Matière</th>
                        <th>📊 Examens</th>
                        <th>⚙️</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($grouped as $matiere_id => $notesMatiere)

                    <tr>

                        <!-- MATIERE -->
                        <td>
                            <span class="badge bg-info">
                                {{ $notesMatiere->first()->matiere->nom ?? '---' }}
                            </span>
                        </td>

                        <!-- EXAMS -->
                        <td class="text-start">

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

                        </td>

                        <!-- ACTIONS -->
                        <td>

                            <!-- ✅ EDIT CORRIGÉ -->
                            <a href="{{ route('notes.edit.matiere', [$etudiant->id, $matiere_id]) }}"
                               class="btn btn-warning btn-sm me-1">
                                ✏️
                            </a>

                            <!-- DELETE -->
                            <form action="{{ route('notes.destroy', $notesMatiere->first()->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Supprimer ?')">
                                    🗑
                                </button>
                            </form>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>
        </div>

        <!-- MOYENNE -->
        @php
            $moyenne = $etudiant->notes->count()
                ? round($etudiant->notes->avg('note'), 2)
                : 0;
        @endphp

        <div class="text-center mt-3">
            <span class="badge bg-primary p-2">
                Moyenne : {{ $moyenne }}
            </span>
        </div>
        <a href="{{ route('notes.pdf', $etudiant->id) }}"
   class="btn btn-danger mt-3">
   📄 Télécharger PDF
</a>


        <!-- BACK -->
        <div class="mt-3 text-center">
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                ⬅ Retour
            </a>
        </div>

    </div>

</div>

</div>

@endsection
