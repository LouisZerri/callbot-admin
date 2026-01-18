<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Commande;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'restaurants' => Restaurant::count(),
            'commandes_total' => Commande::count(),
            'commandes_jour' => Commande::whereDate('created_at', today())->count(),
            'ca_jour' => Commande::whereDate('created_at', today())->sum('total'),
        ];

        $dernieres_commandes = Commande::with('restaurant')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'dernieres_commandes'));
    }
}