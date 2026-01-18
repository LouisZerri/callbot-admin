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
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-16 text-center">
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