@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-success text-white text-center">
            <h4>➕ Ajouter une classe</h4>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('classes.store') }}">
                @csrf

                <div class="mb-3">
                    <label>Nom de la classe</label>
                    <input type="text" name="nom"
                           class="form-control rounded-3"
                           placeholder="Ex: 1ère année"
                           required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>

                    <button class="btn btn-success">
                        <i class="bi bi-save"></i> Enregistrer
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
