@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Modifier l'offre</h1>
        <a href="{{ route('admin.offers.pending') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Informations de l'offre</h3>
            <p class="mt-1 text-sm text-gray-500">Modifiez les détails de l'offre ci-dessous</p>
        </div>

        <form action="{{ route('admin.offers.update', $offer->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Titre de l'offre *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $offer->title) }}" required
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea name="description" id="description" rows="6" required
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $offer->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type d'offre *</label>
                    <select name="type" id="type" required
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="Emploi" {{ old('type', $offer->type) == 'Emploi' ? 'selected' : '' }}>Emploi</option>
                        <option value="Stage" {{ old('type', $offer->type) == 'Stage' ? 'selected' : '' }}>Stage</option>
                        <option value="Freelance" {{ old('type', $offer->type) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sector" class="block text-sm font-medium text-gray-700">Secteur *</label>
                    <select name="sector" id="sector" required
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="Informatique" {{ old('sector', $offer->sector) == 'Informatique & Telecoms' ? 'selected' : '' }}>Informatique & Telecoms</option>
                        <option value="Marketing" {{ old('sector', $offer->sector) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Finance" {{ old('sector', $offer->sector) == 'Finance' ? 'selected' : '' }}>Finance</option>
                        <option value="Santé" {{ old('sector', $offer->sector) == 'Santé' ? 'selected' : '' }}>Santé</option>
                        <option value="Éducation" {{ old('sector', $offer->sector) == 'Éducation' ? 'selected' : '' }}>Éducation</option>
                        <option value="Fournitures courantes" {{ old('sector', $offer->sector) == 'Fournitures courantes' ? 'selected' : '' }}>Fournitures courantes</option>
                        <option value="Transport et logistique" {{ old('sector', $offer->sector) == 'Transport et logistique' ? 'selected' : '' }}>Transport et logistique</option>
                        <option value="Hôtellerie, restauration et loisirs" {{ old('sector', $offer->sector) == 'Hôtellerie, restauration et loisirs' ? 'selected' : '' }}>Hôtellerie, restauration et loisirs</option>
                        <option value="Industrie pharmaceutique" {{ old('sector', $offer->sector) == 'Industrie pharmaceutique' ? 'selected' : '' }}>Industrie pharmaceutique</option>
                        <option value="Sécurité & Sureté" {{ old('sector', $offer->sector) == 'Sécurité & Sureté' ? 'selected' : '' }}>Sécurité & Sureté</option>
                        <option value="Prestations intellectuelles" {{ old('sector', $offer->sector) == 'Prestations intellectuelles' ? 'selected' : '' }}>Prestations intellectuelles</option>
                        <option value="BTP & Matériaux de construction" {{ old('sector', $offer->sector) == 'BTP & Matériaux de construction' ? 'selected' : '' }}>BTP & Matériaux de construction</option>
                        <option value="Commerce" {{ old('sector', $offer->sector) == 'Commerce' ? 'selected' : '' }}>Commerce</option>

                    </select>
                    @error('sector')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700">Région *</label>
                    <select name="region" id="region" required
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="Dakar" {{ old('region', $offer->region) == 'Dakar' ? 'selected' : '' }}>Dakar</option>
                        <option value="Thiès" {{ old('region', $offer->region) == 'Thiès' ? 'selected' : '' }}>Thiès</option>
                        <option value="Saint-Louis" {{ old('region', $offer->region) == 'Saint-Louis' ? 'selected' : '' }}>Saint-Louis</option>
                        <option value="Diourbel" {{ old('region', $offer->region) == 'Diourbel' ? 'selected' : '' }}>Diourbel</option>
                        <option value="Fatick" {{ old('region', $offer->region) == 'Fatick' ? 'selected' : '' }}>Fatick</option>
                        <option value="Kaolack" {{ old('region', $offer->region) == 'Kaolack' ? 'selected' : '' }}>Kaolack</option>
                        <option value="Kaffrine" {{ old('region', $offer->region) == 'Kaffrine' ? 'selected' : '' }}>Kaffrine</option>
                        <option value="Kédougou" {{ old('region', $offer->region) == 'Kédougou' ? 'selected' : '' }}>Kédougou</option>
                        <option value="Kolda" {{ old('region', $offer->region) == 'Kolda' ? 'selected' : '' }}>Kolda</option>
                        <option value="Louga" {{ old('region', $offer->region) == 'Louga' ? 'selected' : '' }}>Louga</option>
                        <option value="Matam" {{ old('region', $offer->region) == 'Matam' ? 'selected' : '' }}>Matam</option>
                        <option value="Sédhiou" {{ old('region', $offer->region) == 'Sédhiou' ? 'selected' : '' }}>Sédhiou</option>
                        <option value="Tambacounda" {{ old('region', $offer->region) == 'Tambacounda' ? 'selected' : '' }}>Tambacounda</option>
                        <option value="Ziguinchor" {{ old('region', $offer->region) == 'Ziguinchor' ? 'selected' : '' }}>Ziguinchor</option>
                        <option value="À distance" {{ old('region', $offer->region) == 'À distance' ? 'selected' : '' }}>À distance</option>
                    </select>
                    @error('region')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700">Budget (FCFA)</label>
                    <input type="number" name="budget" id="budget" value="{{ old('budget', $offer->budget) }}"
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('budget')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deadline" class="block text-sm font-medium text-gray-700">Date limite</label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $offer->deadline ? $offer->deadline->format('Y-m-d') : '') }}"
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('deadline')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700">Entreprise</label>
                    <input type="text" name="company" id="company" value="{{ old('company', $offer->company) }}"
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('company')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700">Durée</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration', $offer->duration) }}"
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email de contact *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $offer->email) }}" required
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone de contact</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $offer->phone) }}"
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="required_skills" class="block text-sm font-medium text-gray-700">Compétences requises</label>
                    <textarea name="required_skills" id="required_skills" rows="3"
                        class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('required_skills', $offer->required_skills) }}</textarea>
                    @error('required_skills')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.offers.pending') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Annuler
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
