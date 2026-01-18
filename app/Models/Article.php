<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'categorie_id',
        'nom',
        'prix',
        'description',
        'disponible'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}