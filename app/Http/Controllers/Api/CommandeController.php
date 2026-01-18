<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    // POST /api/commandes
    public function store(Request $request)
    {
        $validated = $request->validate([
            'twilio_number' => 'required|string',
            'telephone_client' => 'required|string',
            'articles' => 'required|array',
            'total' => 'required|numeric',
            'mode' => 'nullable|string'
        ]);

        $restaurant = Restaurant::where('twilio_number', $validated['twilio_number'])->first();

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant non trouvé'], 404);
        }

        $commande = Commande::create([
            'restaurant_id' => $restaurant->id,
            'telephone_client' => $validated['telephone_client'],
            'articles' => $validated['articles'],
            'total' => $validated['total'],
            'mode' => $validated['mode'] ?? null,
            'statut' => 'nouvelle'
        ]);

        return response()->json([
            'success' => true,
            'commande_id' => $commande->id
        ], 201);
    }

    // GET /api/commandes/{restaurant_id}
    public function index($restaurant_id)
    {
        $commandes = Commande::where('restaurant_id', $restaurant_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($commandes);
    }
}