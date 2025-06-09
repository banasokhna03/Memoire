@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Offres en Attente de Validation</h1>
        <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full">
            {{ $pendingOffers->count() }} offres en attente
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if($pendingOffers->isEmpty())
            <div class="p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Aucune offre en attente</h3>
                <p class="mt-1 text-sm text-gray-500">Toutes les offres ont été traitées.</p>
            </div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($pendingOffers as $offer)
                <li class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <div class="flex items-center">
                                <div class="bg-yellow-100 p-2 rounded-full mr-4">
                                    <i class="fas fa-exclamation text-yellow-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $offer->title }}</p>
                                    <p class="text-sm text-gray-500">
                                        Soumis par: {{ $offer->user->name ?? 'Utilisateur inconnu' }} • {{ $offer->created_at->format('d/m/Y') }}
                                    </p>
                                    <div class="mt-1 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $offer->type }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $offer->sector }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $offer->region }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-end gap-2">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="toggleDetails('offer-details-{{ $offer->id }}')">
                                <i class="fas fa-eye mr-2"></i> Détails
                            </button>
                            
                            <form action="{{ route('admin.offers.validate', $offer->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <i class="fas fa-check mr-2"></i> Valider
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.offers.reject', $offer->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-times mr-2"></i> Rejeter
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Détails de l'offre (initialement masqués) -->
                    <div id="offer-details-{{ $offer->id }}" class="mt-4 hidden">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Description</h4>
                            <p class="text-gray-700 mb-4">{{ $offer->description }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h5 class="font-medium text-gray-900">Informations de l'offre</h5>
                                    <ul class="mt-2 space-y-1 text-sm">
                                        <li><span class="text-gray-500">Budget:</span> {{ number_format($offer->budget, 0, ',', ' ') }} FCFA</li>
                                        <li><span class="text-gray-500">Date limite:</span> {{ $offer->deadline->format('d/m/Y') }}</li>
                                        <li><span class="text-gray-500">Durée:</span> {{ $offer->duration ?? 'Non spécifiée' }}</li>
                                        <li><span class="text-gray-500">Compétences requises:</span> {{ $offer->required_skills }}</li>
                                    </ul>
                                </div>
                                <div>
                                    <h5 class="font-medium text-gray-900">Informations de contact</h5>
                                    <ul class="mt-2 space-y-1 text-sm">
                                        <li><span class="text-gray-500">Entreprise:</span> {{ $offer->company }}</li>
                                        <li><span class="text-gray-500">Email:</span> {{ $offer->email }}</li>
                                        <li><span class="text-gray-500">Téléphone:</span> {{ $offer->phone }}</li>
                                        <li><span class="text-gray-500">Région:</span> {{ $offer->region }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<script>
    function toggleDetails(id) {
        const element = document.getElementById(id);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    }
</script>
@endsection
