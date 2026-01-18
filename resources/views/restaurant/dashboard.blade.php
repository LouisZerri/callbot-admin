@extends('layouts.restaurant')

@section('title', 'Tableau de bord')
@section('subtitle', 'Vue d\'ensemble de votre activité')

@section('content')
<!-- Stats cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 card-hover border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Commandes aujourd'hui</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['commandes_jour'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">
                📞
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 card-hover text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">CA aujourd'hui</p>
                <p class="text-3xl font-bold mt-1">{{ number_format($stats['ca_jour'], 0) }}€</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-2xl">
                💰
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 card-hover border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total commandes</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['commandes_total'] }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-2xl">
                📋
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 card-hover border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">CA total</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['ca_total'], 0) }}€</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">
                📈
            </div>
        </div>
    </div>
</div>

<!-- Dernières commandes -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-lg">Dernières commandes</h3>
        <a href="{{ route('restaurant.commandes') }}" class="text-blue-600 text-sm font-medium hover:underline">Voir tout →</a>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($dernieres_commandes as $commande)
        <div class="px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-lg">
                    📞
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $commande->telephone_client }}</p>
                    <p class="text-sm text-gray-500">{{ $commande->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="font-bold text-lg text-green-600">{{ number_format($commande->total, 2) }}€</p>
            </div>
        </div>
        @empty
        <div class="px-6 py-12 text-center">
            <div class="text-4xl mb-3">📭</div>
            <p class="text-gray-500">Aucune commande pour le moment</p>
        </div>
        @endforelse
    </div>
</div>
@endsection