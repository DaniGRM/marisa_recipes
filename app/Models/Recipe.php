<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    const RECIPE_TYPES = [
        0 => 'Ligero',
        1 => 'Pesado',
        2 => 'Comodín'
    ];
    protected $fillable = [
        'name',
        'type',
        'weekly'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }
}