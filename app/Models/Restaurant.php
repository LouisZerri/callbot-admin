<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'telephone',
        'email',
        'twilio_number',
        'message_accueil',
        'actif',
    ];

    public function categories()
    {
        return $this->hasMany(Categorie::class)->orderBy('ordre');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}