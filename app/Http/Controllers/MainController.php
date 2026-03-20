<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\WeeklyPlan;

class MainController extends Controller
{
    public function index(){
        
        $latestPlan = WeeklyPlan::with('recipes.recipe')->latest()->first();
        $recipeTypes = Recipe::RECIPE_TYPES;
        return view('welcome',compact('latestPlan', 'recipeTypes'));
    }
}