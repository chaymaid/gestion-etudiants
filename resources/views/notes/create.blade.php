@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg border-0 rounded-4">

    <div class="card-header bg-success text-white text-center">
        <h4>➕ Ajouter des notes</h4>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('notes.store') }}">
            @csrf

            <!-- ETUDIANT -->
            <div class="mb-3">
                <label>Étudiant</label>
                <select name="etudiant_id" id="etudiant" class="form-select" required>
                    <option value="">Choisir étudiant</option>
                    @foreach($etudiants as $e)
                        <option value="{{ $e->id }}"
                            data-matieres='@json($e->classe->matieres)'>
                            {{ $e->nom_complet }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- MATIERE -->
            <div class="mb-3">
                <label>Matière</label>
                <select name="matiere_id" id="matiere" class="form-select" required></select>
            </div>

            <!-- EXAMS -->
            <div class="row">

                @foreach(['Exam 1','Exam 2','Exam 3','Exam 4'] as $exam)

                <div class="col-md-6 mb-3">
                    <label>{{ $exam }}</label>
                    <input type="number"
                           name="notes[{{ $exam }}]"
                           class="form-control"
                           min="0" max="20"
                           placeholder="Note {{ $exam }}">
                </div>

                @endforeach

            </div>

            <button class="btn btn-success w-100">
                💾 Enregistrer
            </button>

        </form>

    </div>
</div>

</div>

<script>
document.getElementById('etudiant').addEventListener('change', function () {

    let selected = this.options[this.selectedIndex];

    if(!selected.getAttribute('data-matieres')) return;

    let matieres = JSON.parse(selected.getAttribute('data-matieres'));

    let matiereSelect = document.getElementById('matiere');
    matiereSelect.innerHTML = '<option value="">Choisir matière</option>';

    matieres.forEach(m => {
        matiereSelect.innerHTML += `<option value="${m.id}">${m.nom}</option>`;
    });

});
</script>

@endsection
