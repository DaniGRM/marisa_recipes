<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftEvent extends Model
{
    protected $fillable = [
        'name',
        'hint_text',
        'hint_image',
        'hint_sound',
        'base_points',
    ];

    protected $casts = [
        'base_points' => 'integer',
    ];

    public function userGiftEvents()
    {
        return $this->hasMany(UserGiftEvent::class);
    }
}
