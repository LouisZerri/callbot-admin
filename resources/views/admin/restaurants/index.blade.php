@extends('layouts.admin')

@section('title', 'Restaurants')
@section('subtitle', 'Gérez vos restaurants partenaires')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div class="flex items-center gap-2">
        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
            {{ $restaurants->count() }} restaurant(s)
        </span>
    </div>
    <a href="{{ route('admin.restaurants.create') }}" 
       class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-5 py-2.5 rounded-xl font-medium hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg shadow-blue-500/25">
        + Nouveau restaurant
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
    <span class="text-xl">✅</span>
    {{ session('success') }}
</div>
@endif

<div class="grid gap-4">
    @forelse($restaurants as $restaurant)
    <div class="bg-white rounded-2xl border border-gray-100 p-6 card-hover">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-orange-500/25">
                    🍕
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">{{ $restaurant->nom }}</h3>
                    <p class="text-gray-500 text-sm">{{ $restaurant->adresse }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-8">
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-800">{{ $restaurant->categories_count }}</p>
                    <p class="text-xs text-gray-400">Catégories</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $restaurant->commandes_count }}</p>
                    <p class="text-xs text-gray-400">Commandes</p>
                </div>
                <div class="text-center">
                    @if($restaurant->actif)
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-sm font-medium px-3 py-1 rounded-full">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        Actif
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-sm font-medium px-3 py-1 rounded-full">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        Inactif
                    </span>
                    @endif
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.restaurants.show', $restaurant) }}" 
                       class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Voir
                    </a>
                    <a href="{{ route('admin.restaurants.edit', $restaurant) }}" 
                       class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg font-medium hover:bg-blue-100 transition-colors">
                        Modifier
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-6 text-sm">
            <span class="text-gray-500">📞 {{ $restaurant->telephone }}</span>
            <span class="text-gray-500">✉️ {{ $restaurant->email }}</span>
            <span class="font-mono bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $restaurant->twilio_number }}</span>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
        <div class="text-5xl mb-4">🏪</div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun restaurant</h3>
        <p class="text-gray-500 mb-6">Commencez par ajouter votre premier restaurant</p>
        <a href="{{ route('admin.restaurants.create') }}" 
           class="inline-block bg-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-700 transition-colors">
            + Créer un restaurant
        </a>
    </div>
    @endforelse
</div>
@endsection