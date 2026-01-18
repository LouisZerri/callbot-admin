@extends('layouts.restaurant')

@section('title', 'Mon menu')
@section('subtitle', 'Gérez votre carte')

@section('content')
<!-- Formulaire ajout catégorie -->
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
    <form action="{{ route('restaurant.categories.store') }}" method="POST" class="flex gap-3">
        @csrf
        <input type="text" name="nom" placeholder="Nouvelle catégorie..." required
            class="flex-1 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-700 transition-colors cursor-pointer">
            + Ajouter une catégorie
        </button>
    </form>
</div>

<!-- Catégories -->
<div class="space-y-6">
    @forelse($restaurant->categories as $categorie)
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h3 class="font-bold text-lg">{{ $categorie->nom }}</h3>
                <span class="bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $categorie->articles->count() }} articles</span>
            </div>
            <form action="{{ route('restaurant.categories.delete', $categorie) }}" method="POST" 
                onsubmit="return confirm('Supprimer cette catégorie et tous ses articles ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 text-sm hover:underline cursor-pointer">Supprimer</button>
            </form>
        </div>
        
        <!-- Articles -->
        <div class="divide-y divide-gray-100">
            @foreach($categorie->articles as $article)
            <div class="px-6 py-4 flex justify-between items-center">
                <div class="flex-1">
                    <p class="font-medium text-gray-800">{{ $article->nom }}</p>
                    @if($article->description)
                    <p class="text-sm text-gray-500">{{ $article->description }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-bold text-lg text-green-600">{{ number_format($article->prix, 2) }}€</span>
                    <button onclick="document.getElementById('edit-{{ $article->id }}').classList.toggle('hidden')" 
                        class="text-blue-600 text-sm hover:underline cursor-pointer">Modifier</button>
                    <form action="{{ route('restaurant.articles.delete', $article) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 cursor-pointer">✕</button>
                    </form>
                </div>
            </div>
            <!-- Formulaire modification (caché par défaut) -->
            <div id="edit-{{ $article->id }}" class="hidden px-6 py-4 bg-gray-50 border-t border-gray-100">
                <form action="{{ route('restaurant.articles.update', $article) }}" method="POST" class="flex gap-3">
                    @csrf
                    @method('PUT')
                    <input type="text" name="nom" value="{{ $article->nom }}" required
                        class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" name="description" value="{{ $article->description }}" placeholder="Description"
                        class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="number" name="prix" value="{{ $article->prix }}" step="0.01" required
                        class="w-24 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 cursor-pointer">
                        Enregistrer
                    </button>
                </form>
            </div>
            @endforeach
        </div>

        <!-- Formulaire ajout article -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <form action="{{ route('restaurant.articles.store', $categorie) }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="nom" placeholder="Nom de l'article" required
                    class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="description" placeholder="Description (optionnel)"
                    class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="number" name="prix" placeholder="Prix" step="0.01" required
                    class="w-24 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-900 cursor-pointer">
                    + Article
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
        <div class="text-5xl mb-4">📝</div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Aucune catégorie</h3>
        <p class="text-gray-500">Commencez par créer une catégorie ci-dessus</p>
    </div>
    @endforelse
</div>

<!-- Zone danger -->
<div class="mt-12 bg-red-50 rounded-2xl border border-red-100 p-6">
    <h3 class="text-red-800 font-bold text-lg mb-2">Supprimer mon compte</h3>
    <p class="text-red-600 text-sm mb-4">Cette action supprimera votre restaurant, menu et toutes vos commandes. Irréversible.</p>
    <form action="{{ route('restaurant.compte.delete') }}" method="POST"
        onsubmit="return confirm('Êtes-vous absolument sûr ? Cette action est irréversible.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-red-700 transition-colors cursor-pointer">
            Supprimer mon compte
        </button>
    </form>
</div>
@endsection