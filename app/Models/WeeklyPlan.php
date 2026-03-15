<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlan extends Model
{
    protected $fillable = ['name'];

    public function recipes()
    {
        return $this->hasMany(WeeklyPlanRecipe::class);
    }

    public function weeklyRecipes()
    {
        return $this->recipes()->where('type', 'weekly');
    }

    public function singleRecipes()
    {
        return $this->recipes()->where('type', 'single');
    }
}