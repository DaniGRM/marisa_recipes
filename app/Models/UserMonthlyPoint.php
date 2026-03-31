<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMonthlyPoint extends Model
{
    protected $fillable = ['user_id', 'year', 'month'];

}