@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg">

        <!-- NOM ETUDIANT -->
        <div class="card-header bg-primary text-white">
            <h4>📊 Notes de {{ $etudiant->nom_complet }}</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered text-center">

                <thead class="table-dark">
                    <tr>
                        <th>📚 Matière</th>
                        <th>📊 Note</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($etudiant->notes as $n)
                    <tr>
                        <td>{{ $n->matiere }}</td>
                        <td class="fw-bold text-success">{{ $n->note }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2">Aucune note</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
