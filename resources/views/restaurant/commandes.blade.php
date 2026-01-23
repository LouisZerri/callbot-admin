@extends('layouts.restaurant')

@section('title', 'Commandes')
@section('subtitle', 'Historique de vos commandes')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Client</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($commandes as $commande)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">#{{ $commande->id }}</span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $commande->telephone_client }}</td>
                <td class="px-6 py-4">
                    <span class="font-bold text-green-600">{{ number_format($commande->total, 2) }}€</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('restaurant.commandes.show', $commande) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Voir
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center">
                    <div class="text-5xl mb-4">📭</div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Aucune commande</h3>
                    <p class="text-gray-500">Vos commandes apparaîtront ici</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($commandes->hasPages())
<div class="mt-6">
    {{ $commandes->links() }}
</div>
@endif
@endsection