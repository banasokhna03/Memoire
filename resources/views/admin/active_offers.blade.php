@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Offres Actives</h1>
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full">
            {{ $activeOffers->count() }} offres actives
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if($activeOffers->isEmpty())
            <div class="p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1 mt-2">Aucune offre active</h3>
                <p class="text-sm text-gray-500">Il n'y a actuellement aucune offre publiée.</p>
            </div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($activeOffers as $offer)
                <li class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-3 sm:mb-0">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-2 rounded-full mr-4 flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $offer->title }}</p>
                                    <p class="text-sm text-gray-500">
                                        Publié par: {{ $offer->user->name ?? 'Utilisateur inconnu' }} • {{ $offer->created_at->diffForHumans() }}
                                    </p>
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @if($offer->type)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $offer->type }}
                                        </span>
                                        @endif
                                        @if($offer->sector)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $offer->sector }}
                                        </span>
                                        @endif
                                        @if($offer->region)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $offer->region }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none" onclick="toggleDetails('active-offer-details-{{ $offer->id }}')">
                                <i class="fas fa-eye mr-1"></i> Détails
                            </button>
                            <form action="{{ route('admin.offers.delete', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre active ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>

                    <div id="active-offer-details-{{ $offer->id }}" class="mt-4 hidden">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="text-md font-semibold text-gray-800 mb-2">Description de l'offre</h4>
                            <p class="text-sm text-gray-700 mb-3">{{ $offer->description }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <div><strong class="text-gray-600">Budget:</strong> {{ number_format($offer->budget ?? 0, 0, ',', ' ') }} FCFA</div>
                                <div><strong class="text-gray-600">Date limite:</strong> {{ $offer->deadline ? \Carbon\Carbon::parse($offer->deadline)->format('d/m/Y') : 'N/A' }}</div>
                                <div><strong class="text-gray-600">Durée:</strong> {{ $offer->duration ?? 'Non spécifiée' }}</div>
                                <div class="md:col-span-2"><strong class="text-gray-600">Compétences:</strong> {{ $offer->required_skills ?? 'N/A' }}</div>
                                <div><strong class="text-gray-600">Entreprise:</strong> {{ $offer->company_name ?? $offer->company ?? 'N/A' }}</div>
                                <div><strong class="text-gray-600">Email:</strong> {{ $offer->email ?? 'N/A' }}</div>
                                <div><strong class="text-gray-600">Téléphone:</strong> {{ $offer->phone ?? 'N/A' }}</div>
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