<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlanRecipe extends Model
{
    protected $fillable = [
        'weekly_plan_id',
        'recipe_id',
        'slot',
        'type'
    ];

    public function plan()
    {
        return $this->belongsTo(WeeklyPlan::class, 'weekly_plan_id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}