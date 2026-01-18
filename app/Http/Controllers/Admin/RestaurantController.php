<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Categorie;
use App\Models\Article;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::withCount(['commandes', 'categories'])->get();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('admin.restaurants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'email' => 'required|email',
            'twilio_number' => 'required|string|unique:restaurants',
            'message_accueil' => 'nullable|string',
        ]);

        Restaurant::create($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant créé avec succès !');
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['categories.articles', 'commandes' => function($q) {
            $q->orderBy('created_at', 'desc')->take(10);
        }]);
        return view('admin.restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'email' => 'required|email',
            'twilio_number' => 'required|string|unique:restaurants,twilio_number,' . $restaurant->id,
            'message_accueil' => 'nullable|string',
            'actif' => 'boolean',
        ]);

        $restaurant->update($validated);

        return redirect()->route('admin.restaurants.show', $restaurant)
            ->with('success', 'Restaurant mis à jour !');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant supprimé !');
    }

    // Gestion du menu
    public function addCategorie(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $ordre = $restaurant->categories()->max('ordre') + 1;

        $restaurant->categories()->create([
            'nom' => $validated['nom'],
            'ordre' => $ordre,
        ]);

        return back()->with('success', 'Catégorie ajoutée !');
    }

    public function addArticle(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $categorie->articles()->create($validated);

        return back()->with('success', 'Article ajouté !');
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();
        return back()->with('success', 'Article supprimé !');
    }

    public function deleteCategorie(Categorie $categorie)
    {
        $categorie->delete();
        return back()->with('success', 'Catégorie supprimée !');
    }
}