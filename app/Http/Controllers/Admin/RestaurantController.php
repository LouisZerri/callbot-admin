<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::withCount(['categories', 'commandes'])->get();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('admin.restaurants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'twilio_number' => 'required|string|max:255',
            'message_accueil' => 'nullable|string',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:6',
        ]);

        $restaurant = Restaurant::create([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'twilio_number' => $request->twilio_number,
            'message_accueil' => $request->message_accueil,
        ]);

        User::create([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'password' => Hash::make($request->user_password),
            'role' => 'restaurant',
            'restaurant_id' => $restaurant->id,
        ]);

        return redirect()->route('admin.restaurants.show', $restaurant)
            ->with('success', 'Restaurant et compte créés !');
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['categories.articles', 'commandes' => function ($query) {
            $query->latest()->take(10);
        }, 'users']);

        return view('admin.restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        $restaurant->load('users');
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $user = $restaurant->users->first();

        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'twilio_number' => 'required|string|max:255',
            'message_accueil' => 'nullable|string',
            'actif' => 'boolean',
            'user_name' => 'nullable|string|max:255',
            'user_email' => 'nullable|email|unique:users,email,' . ($user?->id ?? 'NULL'),
            'user_password' => 'nullable|string|min:6',
        ]);

        $restaurant->update([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'twilio_number' => $request->twilio_number,
            'message_accueil' => $request->message_accueil,
            'actif' => $request->boolean('actif'),
        ]);

        // Mise à jour ou création du compte
        if ($request->filled('user_name') && $request->filled('user_email')) {
            if ($user) {
                $user->update([
                    'name' => $request->user_name,
                    'email' => $request->user_email,
                ]);

                if ($request->filled('user_password')) {
                    $user->update(['password' => Hash::make($request->user_password)]);
                }
            } else {
                User::create([
                    'name' => $request->user_name,
                    'email' => $request->user_email,
                    'password' => Hash::make($request->user_password ?? 'password123'),
                    'role' => 'restaurant',
                    'restaurant_id' => $restaurant->id,
                ]);
            }
        }

        return redirect()->route('admin.restaurants.show', $restaurant)
            ->with('success', 'Restaurant modifié !');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->users()->delete();
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restaurant supprimé !');
    }

    public function addCategorie(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $restaurant->categories()->create([
            'nom' => $request->nom,
            'ordre' => $restaurant->categories()->count() + 1,
        ]);

        return back()->with('success', 'Catégorie ajoutée !');
    }

    public function addArticle(Request $request, Categorie $categorie)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $categorie->articles()->create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'description' => $request->description,
        ]);

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