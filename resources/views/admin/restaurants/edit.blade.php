@extends('layouts.admin')

@section('title', 'Modifier ' . $restaurant->nom)
@section('subtitle', 'Modifiez les informations du restaurant')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.restaurants.update', $restaurant) }}" method="POST" class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-8 space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom du restaurant</label>
                <input type="text" name="nom" value="{{ old('nom', $restaurant->nom) }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('nom')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse complète</label>
                <input type="text" name="adresse" value="{{ old('adresse', $restaurant->adresse) }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('adresse')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $restaurant->telephone) }}" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('telephone')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $restaurant->email) }}" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('email')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Numéro Twilio</label>
                <input type="text" name="twilio_number" value="{{ old('twilio_number', $restaurant->twilio_number) }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('twilio_number')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Message d'accueil</label>
                <textarea name="message_accueil" rows="2"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none">{{ old('message_accueil', $restaurant->message_accueil) }}</textarea>
            </div>

            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1" id="actif" {{ $restaurant->actif ? 'checked' : '' }}
                    class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="actif" class="font-medium text-gray-700">Restaurant actif</label>
            </div>
        </div>

        <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
            <a href="{{ route('admin.restaurants.show', $restaurant) }}" class="text-gray-500 hover:text-gray-700 font-medium">
                ← Annuler
            </a>
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl font-medium hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg shadow-blue-500/25">
                Enregistrer les modifications
            </button>
        </div>
    </form>

    <!-- Zone danger -->
    <div class="mt-8 bg-red-50 rounded-2xl border border-red-100 p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-2xl">
                ⚠️
            </div>
            <div class="flex-1">
                <h3 class="text-red-800 font-bold text-lg">Zone danger</h3>
                <p class="text-red-600 text-sm mt-1 mb-4">Supprimer ce restaurant supprimera également toutes ses catégories, articles et commandes. Cette action est irréversible.</p>
                <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST"
                    onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer ce restaurant ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-red-700 transition-colors">
                        🗑️ Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection