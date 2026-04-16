@extends('layouts.app')

@section('content')

<div class="container mt-4">

<h3 class="mb-4">📊 Dashboard Avancé</h3>

<!-- 🔍 FILTRES -->
<form method="GET" class="row mb-4">

    <div class="col-md-3">
        <select name="annee" class="form-select" onchange="this.form.submit()">
            @for($y = date('Y') - 2; $y <= date('Y') + 1; $y++)
                <option value="{{ $y }}" {{ request('annee', date('Y')) == $y ? 'selected' : '' }}>
                    📅 {{ $y }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-3">
        <input type="date"
               name="date"
               value="{{ request('date') }}"
               class="form-control"
               onchange="this.form.submit()">
    </div>

</form>

<!-- CARDS -->
<div class="row text-center">

    <div class="col-md-3">
        <div class="card bg-primary text-white shadow mb-3">
            <div class="card-body">
                <h5>Etudiants</h5>
                <h2>{{ $etudiants }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white shadow mb-3">
            <div class="card-body">
                <h5>Classes</h5>
                <h2>{{ $classes }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white shadow mb-3">
            <div class="card-body">
                <h5>Notes</h5>
                <h2>{{ $notes }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white shadow mb-3">
            <div class="card-body">
                <h5>Absences</h5>
                <h2>{{ $absences }}</h2>
            </div>
        </div>
    </div>

</div>

<!-- CHARTS -->
<div class="row mt-4">

    <div class="col-md-6">
        <div class="card p-3 shadow">
            <h6>📈 Inscriptions</h6>
            <canvas id="inscriptionsChart"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3 shadow">
            <h6>📉 Absences</h6>
            <canvas id="absencesChart"></canvas>
        </div>
    </div>

    <div class="col-md-6 mt-4">
        <div class="card p-3 shadow">
            <h6>📊 Classes</h6>
            <canvas id="classesChart"></canvas>
        </div>
    </div>

    <div class="col-md-6 mt-4">
        <div class="card p-3 shadow">
            <h6>🥧 Notes</h6>
            <canvas id="notesChart"></canvas>
        </div>
    </div>

    <!-- 💰 PAIEMENTS -->
    <div class="col-md-6 mt-4">
        <div class="card p-3 shadow">
            <h6>💰 Paiements</h6>
            <canvas id="paiementsChart"></canvas>
        </div>
    </div>

</div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const mois = ["Jan","Fev","Mar","Avr","Mai","Jun","Jul","Aou","Sep","Oct","Nov","Dec"];

function formatData(data) {
    let result = [];
    for (let i = 1; i <= 12; i++) {
        result.push(data[i] ?? 0);
    }
    return result;
}

// ✅ SÉCURITÉ
const paiementsData = formatData(@json($paiements ?? []));
const inscriptionsData = formatData(@json($inscriptions));
const absencesData = formatData(@json($absencesData));

// 📈 Inscriptions
new Chart(document.getElementById('inscriptionsChart'), {
    type: 'line',
    data: {
        labels: mois,
        datasets: [{
            data: inscriptionsData,
            borderColor: '#4CAF50',
            fill: true
        }]
    }
});

// 📉 Absences
new Chart(document.getElementById('absencesChart'), {
    type: 'line',
    data: {
        labels: mois,
        datasets: [{
            data: absencesData,
            borderColor: '#f44336',
            fill: true
        }]
    }
});

// 📊 Classes
new Chart(document.getElementById('classesChart'), {
    type: 'bar',
    data: {
        labels: @json($labelsClasses),
        datasets: [{
            data: @json($dataClasses),
            backgroundColor: '#2196F3'
        }]
    }
});

// 🥧 Notes
new Chart(document.getElementById('notesChart'), {
    type: 'pie',
    data: {
        labels: @json($matieres),
        datasets: [{
            data: @json($moyennes)
        }]
    }
});

// 💰 Paiements
new Chart(document.getElementById('paiementsChart'), {
    type: 'bar',
    data: {
        labels: mois,
        datasets: [{
            data: paiementsData,
            backgroundColor: '#00BCD4'
        }]
    }
});

</script>

@endsection
