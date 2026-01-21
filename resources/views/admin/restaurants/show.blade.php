@extends('layouts.admin')

@section('title', $restaurant->nom)
@section('subtitle', $restaurant->adresse)

@section('content')

<div class="flex gap-8">
    <!-- Colonne gauche : Infos + Comptes -->
    <div class="w-1/3 space-y-6 sticky top-0 self-start">
        <!-- Card infos -->
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-br from-orange-400 to-red-500 p-6 text-white">
                <div class="flex justify-between items-start">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl">
                        🍕
                    </div>
                    @if($restaurant->actif)
                    <span class="bg-white/20 text-white text-xs font-medium px-3 py-1 rounded-full">Actif</span>
                    @else
                    <span class="bg-red-500 text-white text-xs font-medium px-3 py-1 rounded-full">Inactif</span>
                    @endif
                </div>
                <h3 class="text-xl font-bold mt-4">{{ $restaurant->nom }}</h3>
                <p class="text-orange-100 text-sm">{{ $restaurant->adresse }}</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="text-gray-400">📞</span>
                    <span class="text-gray-700">{{ $restaurant->telephone }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-gray-400">✉️</span>
                    <span class="text-gray-700">{{ $restaurant->email }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-gray-400">🔗</span>
                    <span class="font-mono bg-gray-100 px-2 py-1 rounded text-sm text-gray-600">{{ $restaurant->twilio_number }}</span>
                </div>
            </div>
            <div class="px-6 pb-6">
                <a href="{{ route('admin.restaurants.edit', $restaurant) }}" 
                   class="block w-full text-center bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                    ✏️ Modifier les infos
                </a>
            </div>
        </div>

        <!-- Dernières commandes -->
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold">Dernières commandes</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($restaurant->commandes as $commande)
                <div class="px-6 py-3 flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ preg_replace('/^33(\d)(\d{2})(\d{2})(\d{2})(\d{2})$/', '+33 $1 $2 $3 $4 $5', $commande->telephone_client) }}</p>
                        <p class="text-xs text-gray-400">{{ $commande->created_at->format('d/m H:i') }}</p>
                    </div>
                    <p class="font-bold text-green-600">{{ number_format($commande->total, 2) }}€</p>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-400 text-sm">Aucune commande</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Colonne droite : Menu -->
    <div class="w-2/3">
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">Menu du restaurant</h3>
                    <p class="text-gray-500 text-sm">Gérez les catégories et articles</p>
                </div>
                <form action="{{ route('admin.restaurants.addCategorie', $restaurant) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="nom" placeholder="Nouvelle catégorie..." required
                        class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors cursor-pointer">
                        + Ajouter
                    </button>
                </form>
            </div>

            <div class="p-6 space-y-6">
                @forelse($restaurant->categories as $categorie)
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <div class="bg-gray-50 px-5 py-4 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <h4 class="font-bold text-gray-800">{{ $categorie->nom }}</h4>
                            <span class="bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $categorie->articles->count() }} articles</span>
                        </div>
                        <form action="{{ route('admin.categories.delete', $categorie) }}" method="POST" 
                            onsubmit="return confirm('Supprimer cette catégorie et tous ses articles ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 text-sm cursor-pointer">🗑️ Supprimer</button>
                        </form>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach($categorie->articles as $article)
                        <div class="px-5 py-3 flex justify-between items-center hover:bg-gray-50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-800">{{ $article->nom }}</p>
                                @if($article->description)
                                <p class="text-sm text-gray-500">{{ $article->description }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-lg text-green-600">{{ number_format($article->prix, 2) }}€</span>
                                <form action="{{ route('admin.articles.delete', $article) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors cursor-pointer">✕</button>
                                </form>
                            </div>
                        </div>
                        @endforeach

                        <form action="{{ route('admin.categories.addArticle', $categorie) }}" method="POST" 
                            class="px-5 py-4 bg-gray-50 flex gap-3">
                            @csrf
                            <input type="text" name="nom" placeholder="Nom de l'article" required
                                class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="text" name="description" placeholder="Description (optionnel)"
                                class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="number" name="prix" placeholder="Prix" step="0.01" required
                                class="w-24 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition-colors cursor-pointer">
                                + Article
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="text-5xl mb-4">📝</div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Aucune catégorie</h3>
                    <p class="text-gray-500">Créez une catégorie pour commencer à ajouter des articles</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection