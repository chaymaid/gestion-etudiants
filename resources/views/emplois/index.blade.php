@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg rounded-4">

<div class="card-header bg-primary text-white d-flex justify-content-between">
    <h5>📅 Emploi du temps - {{ $classe->nom }}</h5>

    <a href="{{ route('emplois.create', $classe->id) }}" class="btn btn-light">
        ➕ Ajouter
    </a>
</div>

<div class="card-body">

<table class="table table-bordered text-center">
    <thead class="table-dark">
        <tr>
            <th>Jour</th>
            <th>Heure</th>
            <th>Matière</th>
            <th>Prof</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($emplois as $e)
        <tr>
            <td>{{ $e->jour }}</td>
            <td>{{ $e->heure_debut }} - {{ $e->heure_fin }}</td>
            <td>{{ $e->matiere }}</td>
            <td>{{ $e->professeur }}</td>

            <td>
                <a href="{{ route('emplois.edit', $e->id) }}" class="btn btn-warning btn-sm">✏️</a>

                <form action="{{ route('emplois.destroy', $e->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">🗑️</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

</div>
</div>
</div>

@endsection
