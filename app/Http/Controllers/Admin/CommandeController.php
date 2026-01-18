<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('restaurant')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.commandes.index', compact('commandes'));
    }

    public function show(Commande $commande)
    {
        $commande->load('restaurant');
        return view('admin.commandes.show', compact('commande'));
    }
}