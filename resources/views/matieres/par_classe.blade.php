@extends('layouts.app')

@section('content')

<div class="container mt-4">

<div class="card shadow-lg">

    <div class="card-header bg-info text-white">
        📚 Matières de : {{ $classe->nom }}
    </div>

    <div class="card-body">

        <ul class="list-group">
            @foreach($classe->matieres as $m)
                <li class="list-group-item d-flex justify-content-between">
                    {{ $m->nom }}

                    <form action="{{ route('matieres.destroy', $m->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </li>
            @endforeach
        </ul>

    </div>

</div>

</div>

@endsection
