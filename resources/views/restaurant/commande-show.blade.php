@extends('layouts.restaurant')

@section('title', 'Commande #' . $commande->id)
@section('subtitle', 'Détails de la commande')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white p-8">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Commande</p>
                    <p class="text-4xl font-bold mt-1">#{{ $commande->id }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-400 text-sm font-medium">Total</p>
                    <p class="text-4xl font-bold text-green-400 mt-1">{{ number_format($commande->total, 2) }}€</p>
                </div>
            </div>
        </div>

        <!-- Infos -->
        <div class="p-8 border-b border-gray-100">
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-500 text-sm font-medium">Client</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xl">📞</span>
                        <span class="font-bold text-gray-800">{{ $commande->telephone_client }}</span>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-500 text-sm font-medium">Date & heure</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xl">🕐</span>
                        <span class="font-bold text-gray-800">{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-500 text-sm font-medium">Mode</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xl">🛍️</span>
                        <span class="font-bold text-gray-800">{{ $commande->mode ?? 'Non précisé' }}</span>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-500 text-sm font-medium">Statut</p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($commande->statut === 'nouvelle')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Nouvelle</span>
                        @elseif($commande->statut === 'en_cours')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">En cours</span>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Terminée</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles -->
        <div class="p-8">
            <h3 class="font-bold text-lg mb-4">Articles commandés</h3>
            <div class="space-y-3">
                @foreach($commande->articles as $article)
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <span class="bg-white w-10 h-10 rounded-lg flex items-center justify-center font-bold text-blue-600">
                            {{ $article['quantite'] ?? 1 }}x
                        </span>
                        <span class="font-medium text-gray-800">{{ $article['nom'] ?? $article['article'] ?? 'Article' }}</span>
                    </div>
                    <span class="font-bold text-lg">{{ number_format($article['prix'] ?? $article['prix_unitaire'] ?? 0, 2) }}€</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Total -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-6 flex justify-between items-center">
            <span class="text-xl font-semibold">Total à payer</span>
            <span class="text-3xl font-bold">{{ number_format($commande->total, 2) }}€</span>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('restaurant.commandes') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            ← Retour aux commandes
        </a>
    </div>
</div>
@endsection
