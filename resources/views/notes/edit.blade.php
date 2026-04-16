@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow border-0 rounded-4">

    <!-- HEADER -->
    <div class="card-header bg-warning text-dark text-center">
        <h5>✏️ Modifier les notes</h5>
    </div>

    <div class="card-body">

        <div class="mb-3 text-center">
            <strong>👤 {{ $etudiant->nom_complet }}</strong>
        </div>

        <form method="POST"
              action="{{ route('notes.update.matiere', [$etudiant->id, $matiere_id]) }}">
            @csrf
            @method('PUT')

            @php
                $exams = ['Exam 1','Exam 2','Exam 3','Exam 4'];
            @endphp

            @foreach($exams as $exam)

                <div class="mb-3">
                    <label class="fw-bold">{{ $exam }}</label>

                    <input type="number"
                           name="notes[{{ $exam }}]"
                           value="{{ $notes[$exam]->note ?? '' }}"
                           class="form-control"
                           min="0" max="20">
                </div>

            @endforeach

            <button class="btn btn-success w-100">
                💾 Enregistrer
            </button>

        </form>

        <div class="text-center mt-3">
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                ⬅ Retour
            </a>
        </div>

    </div>
</div>

</div>

@endsection
