<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<style>
body {
    font-family: DejaVu Sans;
    margin: 20px;
}

/* CADRE GLOBAL */
.page {
    border: 4px double #000;
    padding: 20px;
}

/* HEADER */
.header {
    text-align: center;
}

/* NOM ECOLE */
.school-name {
    font-size: 26px;
    font-weight: bold;
    color: #2c3e50;
    letter-spacing: 1px;
}

.school-slogan {
    font-size: 13px;
    color: #555;
    margin-bottom: 10px;
    font-style: italic;
}

.title {
    font-size: 22px;
    font-weight: bold;
}

.subtitle {
    font-size: 14px;
    margin-bottom: 10px;
}

.line {
    border-top: 2px solid #000;
    margin: 10px 0;
}

/* INFOS */
.info p {
    margin: 5px 0;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th {
    background: #2c3e50;
    color: white;
    padding: 6px;
    font-size: 11px;
}

td {
    border: 1px solid #000;
    padding: 6px;
    text-align: center;
    font-size: 11px;
}

/* COLORS */
.good { background: #d4edda; }
.medium { background: #fff3cd; }
.bad { background: #f8d7da; }

/* FOOTER */
.footer {
    margin-top: 20px;
}

.signature {
    margin-top: 50px;
    text-align: right;
}
</style>

</head>
<body>

<div class="page">

<!-- HEADER -->
<div class="header">

    <div class="school-name">
        📚 École MarwaneSup
    </div>

    <div class="school-slogan">
        Apprendre et Réussir
    </div>

    <div class="title">BULLETIN SCOLAIRE</div>
    <div class="subtitle">Année scolaire : 2025 / 2026</div>

</div>

<div class="line"></div>

<!-- INFOS -->
<div class="info">
    <p><strong>Étudiant :</strong> {{ $etudiant->nom_complet }}</p>
    <p><strong>Classe :</strong> {{ $etudiant->classe->nom }}</p>
</div>

@php
$grouped = $etudiant->notes->groupBy('matiere_id');
$exams = ['Exam 1','Exam 2','Exam 3','Exam 4'];
@endphp

<!-- TABLE -->
<table>
<thead>
<tr>
    <th>Matière</th>
    @foreach($exams as $exam)
        <th>{{ $exam }}</th>
    @endforeach
    <th>Moyenne</th>
</tr>
</thead>

<tbody>
@foreach($grouped as $matiere_id => $notesMatiere)

@php
$moy = round($notesMatiere->avg('note'), 2);
$class = $moy >= 16 ? 'good' : ($moy >= 10 ? 'medium' : 'bad');
@endphp

<tr class="{{ $class }}">
    <td>{{ $notesMatiere->first()->matiere->nom }}</td>

    @foreach($exams as $exam)
        @php $n = $notesMatiere->firstWhere('type_exam', $exam); @endphp
        <td>{{ $n ? $n->note : '-' }}</td>
    @endforeach

    <td><strong>{{ $moy }}</strong></td>
</tr>

@endforeach
</tbody>
</table>

@php
$moyenne = round($etudiant->notes->avg('note'), 2);
@endphp

<!-- FOOTER -->
<div class="footer">
    <p><strong>Moyenne Générale :</strong> {{ $moyenne }}</p>

    <div class="signature">
        Signature du Directeur<br><br>
        ____________________
    </div>
</div>

</div>

</body>
</html>
