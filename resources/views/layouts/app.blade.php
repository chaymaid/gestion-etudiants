<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="bg-dark text-white p-3" style="width:250px; min-height:100vh; position:relative;">

        <h4 class="mb-4">🎓 Admin Panel</h4>

        <ul class="nav flex-column">

            <li class="nav-item mb-2 border-bottom pb-2">
                <a href="{{ route('dashboard') }}" class="nav-link text-white">📊 Dashboard</a>
            </li>

            <li class="nav-item mb-2 border-bottom pb-2">
                <a href="{{ route('etudiants.index') }}" class="nav-link text-white">👨‍🎓 Etudiants</a>
            </li>

            <li class="nav-item mb-2 border-bottom pb-2">
                <a href="{{ route('classes.index') }}" class="nav-link text-white">🏫 Classes</a>
            </li>
<li class="nav-item mb-2 border-bottom pb-2">
    <a href="{{ route('classes.index') }}" class="nav-link text-white">📅 Emploi du temps</a>
</li>
<li class="nav-item mb-2 border-bottom pb-2">
                <a href="{{ route('matieres.index') }}" class="nav-link text-white">📚 Matieres</a>
            </li>

            <li class="nav-item mb-2 border-bottom pb-2">
    <a href="{{ route('inscriptions.index') }}" class="nav-link text-white">✏️ Inscriptions</a>
</li>

            <li class="nav-item mb-2 border-bottom pb-2">
                <a href="{{ route('notes.index') }}" class="nav-link text-white">📝 Notes</a>
            </li>
             <li class="nav-item mb-2 border-bottom pb-2">
    <a href="{{ route('quran.index') }}" class="nav-link text-white">📖 Quran </a>
</li>

            <li class="nav-item">
                <a href="{{ route('absences.index') }}" class="nav-link text-white">❌ Absences</a>
            </li>


        </ul>

        <!-- Logout -->
        <div style="position:absolute; bottom:20px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm">Déconnexion</button>
            </form>
        </div>

    </div>

    <!-- Content -->
    <div class="flex-grow-1">

        <!-- Topbar -->
       <div class="bg-white shadow p-3 text-end">
    👤 {{ Auth::user()->name }}
</div>

        <!-- Page Content -->
        <div class="p-4">
            @yield('content')
        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
