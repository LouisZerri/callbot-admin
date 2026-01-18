@extends('layouts.admin')

@section('title', 'Nouveau restaurant')
@section('subtitle', 'Ajoutez un nouveau restaurant partenaire')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.restaurants.store') }}" method="POST" class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        @csrf
        
        <div class="p-8 space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom du restaurant</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required placeholder="Ex: Via Pizza"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('nom')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse complète</label>
                <input type="text" name="adresse" value="{{ old('adresse') }}" required placeholder="Ex: 5 rue des Sergents, 80000 Amiens"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('adresse')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" required placeholder="03 22 91 83 00"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('telephone')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="contact@restaurant.fr"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('email')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Numéro Twilio</label>
                <input type="text" name="twilio_number" value="{{ old('twilio_number') }}" placeholder="+19592712087" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <p class="text-gray-400 text-sm mt-2">Le numéro Twilio assigné à ce restaurant</p>
                @error('twilio_number')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Message d'accueil (optionnel)</label>
                <textarea name="message_accueil" rows="2" placeholder="Bienvenue chez Via Pizza !"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none">{{ old('message_accueil') }}</textarea>
            </div>
        </div>

        <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
            <a href="{{ route('admin.restaurants.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">
                ← Annuler
            </a>
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl font-medium hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg shadow-blue-500/25">
                Créer le restaurant
            </button>
        </div>
    </form>
</div>
@endsection