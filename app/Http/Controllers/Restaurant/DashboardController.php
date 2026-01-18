<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $restaurant = $user->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('login')
                ->with('error', 'Aucun restaurant associé à ce compte.');
        }

        $stats = [
            'commandes_jour' => $restaurant->commandes()->whereDate('created_at', today())->count(),
            'ca_jour' => $restaurant->commandes()->whereDate('created_at', today())->sum('total'),
            'commandes_total' => $restaurant->commandes()->count(),
            'ca_total' => $restaurant->commandes()->sum('total'),
        ];

        $dernieres_commandes = $restaurant->commandes()->latest()->take(10)->get();

        return view('restaurant.dashboard', compact('restaurant', 'stats', 'dernieres_commandes'));
    }

    public function commandes()
    {
        /** @var User $user */
        $user = Auth::user();
        $restaurant = $user->restaurant;
        $commandes = $restaurant->commandes()->latest()->paginate(20);

        return view('restaurant.commandes', compact('restaurant', 'commandes'));
    }

    public function menu()
    {
        /** @var User $user */
        $user = Auth::user();
        $restaurant = $user->restaurant->load('categories.articles');

        return view('restaurant.menu', compact('restaurant'));
    }

    public function addCategorie(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $restaurant = $user->restaurant;

        $restaurant->categories()->create([
            'nom' => $request->nom,
            'ordre' => $restaurant->categories()->count() + 1,
        ]);

        return back()->with('success', 'Catégorie ajoutée !');
    }

    public function deleteCategorie(Categorie $categorie)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($categorie->restaurant_id !== $user->restaurant_id) {
            return back()->with('error', 'Action non autorisée.');
        }

        $categorie->delete();

        return back()->with('success', 'Catégorie supprimée !');
    }

    public function addArticle(Request $request, Categorie $categorie)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($categorie->restaurant_id !== $user->restaurant_id) {
            return back()->with('error', 'Action non autorisée.');
        }

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

    public function updateArticle(Request $request, Article $article)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($article->categorie->restaurant_id !== $user->restaurant_id) {
            return back()->with('error', 'Action non autorisée.');
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $article->update([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Article modifié !');
    }

    public function deleteArticle(Article $article)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($article->categorie->restaurant_id !== $user->restaurant_id) {
            return back()->with('error', 'Action non autorisée.');
        }

        $article->delete();

        return back()->with('success', 'Article supprimé !');
    }

    public function deleteCompte(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $restaurant = $user->restaurant;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Supprimer le restaurant (et ses catégories, articles, commandes via cascade)
        if ($restaurant) {
            $restaurant->delete();
        }

        $user->delete();

        return redirect()->route('login')
            ->with('success', 'Votre compte a été supprimé.');
    }
}