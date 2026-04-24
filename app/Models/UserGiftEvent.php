<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGiftEvent extends Model
{
    protected $fillable = [
        'user_id',
        'gift_event_id',
        'used_text',
        'used_image',
        'used_sound',
        'completed',
        'points_earned',
    ];

    protected $casts = [
        'used_text' => 'boolean',
        'used_image' => 'boolean',
        'used_sound' => 'boolean',
        'completed' => 'boolean',
        'points_earned' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function giftEvent()
    {
        return $this->belongsTo(GiftEvent::class);
    }
}
