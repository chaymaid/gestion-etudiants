@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-warning text-dark text-center">
            <h4>✏️ Modifier classe</h4>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('classes.update', $classe->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nom de la classe</label>
                    <input type="text" name="nom"
                           value="{{ $classe->nom }}"
                           class="form-control rounded-3" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>

                    <button class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Modifier
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
