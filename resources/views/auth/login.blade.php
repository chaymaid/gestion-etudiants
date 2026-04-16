<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body class="min-h-screen flex bg-gray-100">

    <!-- LEFT PANEL -->
    <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-700 to-blue-500 text-white">

        <div class="p-10 flex flex-col justify-between w-full">

            <!-- LOGO -->
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-4 rounded-xl">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">EduWithMarwane</h1>
                    <p class="text-sm opacity-80">Gestion des Etudiants</p>
                </div>
            </div>

            <!-- IMAGE -->
            <div class="flex justify-center my-10">
                <img src="{{ asset('images/img.png') }}" class="w-3/4">
            </div>

            <!-- TEXT -->
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-3">
                    Simplifiez la gestion de vos étudiants
                </h2>
                <p class="text-sm opacity-80">
                    Une plateforme complète pour suivre, gérer et accompagner vos étudiants.
                </p>
            </div>

        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="w-full md:w-1/2 flex items-center justify-center px-6">

        <div class="bg-white rounded-2xl shadow-xl p-10 w-full max-w-md">

            <!-- TITLE -->
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">
                Connexion
            </h2>
            <p class="text-center text-gray-500 mb-6">
                Accédez à votre espace
            </p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Adresse Email</label>
                    <div class="flex items-center border rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-indigo-400">
                        <i class="fa fa-envelope text-gray-400 mr-2"></i>
                        <input type="email" name="email"
                               placeholder="votre@email.com"
                               class="w-full outline-none"
                               required>
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Mot de passe</label>
                    <div class="flex items-center border rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-indigo-400">
                        <i class="fa fa-lock text-gray-400 mr-2"></i>
                        <input type="password" name="password"
                               placeholder="Votre mot de passe"
                               class="w-full outline-none"
                               required>
                    </div>
                </div>

                <!-- OPTIONS -->
                <div class="flex justify-between items-center mb-5 text-sm">
                    <label class="flex items-center text-gray-600">
                        <input type="checkbox" class="mr-2">
                        Se souvenir
                    </label>

                    <a href="{{ route('password.request') }}"
                       class="text-indigo-600 hover:underline">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- BUTTON -->
                <button class="w-full bg-gradient-to-r from-indigo-600 to-blue-500
                               text-white py-3 rounded-lg font-semibold
                               hover:opacity-90 transition shadow-md">
                    Se connecter
                </button>

                <!-- REGISTER -->
                <p class="text-center mt-6 text-sm text-gray-600">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}"
                       class="text-indigo-600 font-semibold hover:underline">
                        Créer un compte
                    </a>
                </p>

            </form>
        </div>

    </div>

</body>
</html>
