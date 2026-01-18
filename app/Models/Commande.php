<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'restaurant_id',
        'telephone_client',
        'articles',
        'total',
        'mode',
        'statut'
    ];

    protected $casts = [
        'articles' => 'array'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}