<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    // GET /api/restaurant/{twilio_number}
    public function getByTwilio($twilio_number)
    {
        $restaurant = Restaurant::where('twilio_number', $twilio_number)
            ->where('actif', true)
            ->with(['categories.articles' => function($query) {
                $query->where('disponible', true);
            }])
            ->first();

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant non trouvé'], 404);
        }

        return response()->json([
            'restaurant' => [
                'id' => $restaurant->id,
                'nom' => $restaurant->nom,
                'adresse' => $restaurant->adresse,
                'telephone' => $restaurant->telephone,
                'email' => $restaurant->email,
                'message_accueil' => $restaurant->message_accueil
            ],
            'menu' => $restaurant->categories->map(function($cat) {
                return [
                    'categorie' => $cat->nom,
                    'articles' => $cat->articles->map(function($art) {
                        return [
                            'nom' => $art->nom,
                            'prix' => $art->prix,
                            'description' => $art->description
                        ];
                    })
                ];
            })
        ]);
    }

    // GET /api/restaurants
    public function index()
    {
        return Restaurant::where('actif', true)->get();
    }
}