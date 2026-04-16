@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-success text-white">
            📖 Gestion Quran
        </div>

        <div class="card-body">

            <!-- FILTRE -->
            <form method="GET" action="{{ route('quran.index') }}" class="row mb-4">

                <div class="col-md-4">
                    <label>Classe</label>
                    <select name="classe_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Choisir classe --</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $classe_id == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Étudiant</label>
                    <select name="etudiant_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Choisir étudiant --</option>
                        @foreach($etudiants as $etudiant)
                            <option value="{{ $etudiant->id }}" {{ $etudiant_id == $etudiant->id ? 'selected' : '' }}>
                                {{ $etudiant->nom_complet }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </form>

            <!-- AJOUT -->
            @if($etudiant_id)
                <a href="{{ route('quran.create', ['etudiant_id' => $etudiant_id]) }}" class="btn btn-success mb-3">
                    ➕ Ajouter note Quran
                </a>
            @endif

            <!-- TABLE -->
            <table class="table table-bordered">

                <thead class="table-dark">
                    <tr>
                        <th>Hizb</th>
                        <th>Juz</th>
                        <th>Type</th>
                        <th>Note</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($qurans as $quran)
                    <tr>
                        <td>{{ $quran->hizb }}</td>
                        <td>{{ $quran->juz }}</td>
                        <td>{{ $quran->type }}</td>
                        <td>{{ $quran->note }}</td>
                        <td>{{ $quran->date }}</td>

                        <td>
                            <!-- EDIT -->
                            <a href="{{ route('quran.edit', $quran->id) }}" class="btn btn-warning btn-sm">✏️</a>

                            <!-- DELETE -->
                            <form action="{{ route('quran.destroy', $quran->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucune donnée</td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
