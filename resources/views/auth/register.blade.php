<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Appel d'Offres Sénégal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <img class="mx-auto h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>            
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Créez votre compte
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Déjà un compte? <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500">Connectez-vous</a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Il y a eu quelques problèmes avec votre soumission.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" autocomplete="name" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('name') border-red-500 @enderror"
                                   value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('email') border-red-500 @enderror"
                                   value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                   
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <div class="mt-1">
                            <input id="phone" name="phone" type="tel" autocomplete="tel"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('phone') border-red-500 @enderror"
                                   value="{{ old('phone') }}">
                        </div>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('password') border-red-500 @enderror">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
                        <div class="mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('password_confirmation') border-red-500 @enderror">
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox"
                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" required>
                        <label for="terms" class="ml-2 block text-sm text-gray-900">
                            J'accepte les <a href="#" class="text-purple-600 hover:text-purple-500">conditions d'utilisation</a>
                        </label>
                    </div>
                    {{-- Vous pouvez également ajouter un message d'erreur pour les termes si nécessaire --}}
                    {{-- @error('terms')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror --}}

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            S'inscrire
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>