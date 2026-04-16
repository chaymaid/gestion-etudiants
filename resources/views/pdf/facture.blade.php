<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
body {
    font-family: DejaVu Sans;
    font-size: 12px;
    padding: 30px;
}

/* CADRE */
.page {
    border: 4px double #000;
    padding: 20px;
}

/* HEADER */
.header {
    text-align: center;
}

/* ECOLE */
.school-name {
    font-size: 24px;
    font-weight: bold;
    color: #2c3e50;
}

.school-slogan {
    font-size: 12px;
    color: #555;
    margin-bottom: 10px;
    font-style: italic;
}

.facture-info {
    text-align: right;
    margin-top: 10px;
}

/* LINE */
.line {
    border-top: 2px solid #000;
    margin: 15px 0;
}

/* INFOS */
.info {
    margin-top: 10px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th {
    background: #2c3e50;
    color: white;
    padding: 8px;
}

td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
}

/* MOIS */
.mois {
    margin-top: 20px;
}

/* TOTAL */
.total {
    margin-top: 20px;
    text-align: right;
    font-size: 16px;
    font-weight: bold;
}

/* FOOTER */
.footer {
    margin-top: 50px;
    display: flex;
    justify-content: space-between;
}

.signature, .cachet {
    text-align: center;
}

.line-sign {
    margin-top: 40px;
    border-top: 1px solid #000;
    width: 200px;
    margin-left: auto;
    margin-right: auto;
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

    <div class="facture-info">
        <strong>FACTURE</strong><br>
        N° : {{ $numero }}<br>
        Date : {{ $date }}
    </div>

</div>

<div class="line"></div>

<!-- CLIENT -->
<div class="info">
    <strong>Famille :</strong> {{ $famille->first()->nom_complet }} <br>
    <strong>Nombre d'enfants :</strong> {{ $famille->count() }}
</div>

<!-- TABLE -->
<table>
<thead>
<tr>
    <th>Nom</th>
    <th>Classe</th>
</tr>
</thead>

<tbody>
@foreach($famille as $e)
<tr>
    <td>{{ $e->nom_complet }}</td>
    <td>{{ $e->classe->nom ?? '-' }}</td>
</tr>
@endforeach
</tbody>

</table>

<!-- MOIS PAYÉS -->
<div class="mois">
<h4>📅 Mois payés</h4>

@foreach($moisPayes as $annee => $mois)
    <p>
        <strong>{{ $annee }} :</strong>
        {{ implode(', ', $mois) }}
    </p>
@endforeach
</div>

<!-- TOTAL -->
<div class="total">
    Total Famille : {{ $famille->first()->prix }} DH
</div>

<!-- FOOTER -->
<div class="footer">

    <div class="cachet">
        Cachet
        <div class="line-sign"></div>
    </div>

    <div class="signature">
        Signature
        <div class="line-sign"></div>
    </div>

</div>

</div>

</body>
</html>
