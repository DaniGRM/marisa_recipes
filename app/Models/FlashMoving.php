<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashMoving extends Model
{
    protected $fillable = ['user_id'];
    protected $table = 'flash_moving';
}