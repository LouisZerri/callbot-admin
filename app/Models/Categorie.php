<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'restaurant_id',
        'nom',
        'ordre'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}