@extends('layouts.admin')

@section('title', 'Commandes')
@section('subtitle', 'Historique de toutes les commandes CallBot')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Commande</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Restaurant</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($commandes as $commande)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">#{{ $commande->id }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center text-sm">🍕</div>
                        <span class="font-medium text-gray-800">{{ $commande->restaurant->nom }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $commande->telephone_client }}</td>
                <td class="px-6 py-4">
                    <span class="font-bold text-green-600">{{ number_format($commande->total, 2) }}€</span>
                </td>
                <td class="px-6 py-4">
                    @if($commande->statut == 'nouvelle')
                    <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                        Nouvelle
                    </span>
                    @elseif($commande->statut == 'en_cours')
                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-xs font-medium px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                        En cours
                    </span>
                    @elseif($commande->statut == 'terminee')
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                        Terminée
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.commandes.show', $commande) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Voir détails →
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center">
                    <div class="text-5xl mb-4">📭</div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Aucune commande</h3>
                    <p class="text-gray-500">Les commandes passées via CallBot apparaîtront ici</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($commandes->hasPages())
<div class="mt-6">
    {{ $commandes->links() }}
</div>
@endif
@endsection