<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\WeeklyPlan;
use App\Models\WeeklyPlanRecipe;
use Illuminate\Support\Facades\DB;

class WeeklyPlanController extends Controller
{
    public function generate()
    {
        // 1️⃣ Obtener IDs de recetas usadas en las últimas 2 semanas
        $recentPlanIds = WeeklyPlan::latest()->take(2)->pluck('id');

        $recentRecipeIds = WeeklyPlanRecipe::whereIn('weekly_plan_id', $recentPlanIds)
            ->pluck('recipe_id')
            ->toArray();

        // 2️⃣ Preparar arrays de recetas disponibles
        $weeklyRecipes = Recipe::where('weekly', true)
            ->whereNotIn('id', $recentRecipeIds)
            ->get()
            ->groupBy('type'); // agrupar por tipo (0,1,2 o 'ligero','pesado','comodin')

        $singleRecipes = Recipe::where('weekly', false)
            ->whereNotIn('id', $recentRecipeIds)
            ->get();

        // 3️⃣ Seleccionar 2 recetas weekly de tipos distintos
        $weeklySelected = [];

        $availableTypes = $weeklyRecipes->keys()->toArray();

        if(count($availableTypes) < 2){
            return back()->with('error', 'No hay suficientes recetas weekly de tipos distintos disponibles.');
        }

        shuffle($availableTypes);
        $type1 = $availableTypes[0];
        $type2 = $availableTypes[1];

        $weeklySelected[] = $weeklyRecipes[$type1]->random();
        $weeklySelected[] = $weeklyRecipes[$type2]->random();

        // 4️⃣ Seleccionar 1 receta single
        if($singleRecipes->isEmpty()){
            return back()->with('error', 'No hay recetas single disponibles.');
        }

        $singleSelected = $singleRecipes->random();

        // 5️⃣ Crear el plan semanal
        $plan = WeeklyPlan::create([
            'name' => 'Semana ' . (WeeklyPlan::count() + 1)
        ]);

        // 6️⃣ Guardar las recetas en la tabla pivote
        WeeklyPlanRecipe::create([
            'weekly_plan_id' => $plan->id,
            'recipe_id' => $weeklySelected[0]->id,
            'slot' => 0,
            'type' => 'weekly'
        ]);

        WeeklyPlanRecipe::create([
            'weekly_plan_id' => $plan->id,
            'recipe_id' => $weeklySelected[1]->id,
            'slot' => 1,
            'type' => 'weekly'
        ]);

        WeeklyPlanRecipe::create([
            'weekly_plan_id' => $plan->id,
            'recipe_id' => $singleSelected->id,
            'slot' => 2,
            'type' => 'single'
        ]);

        return redirect()->back()->with('success', 'Plan semanal generado correctamente.');
    }

    public function index()
    {
        $plans = WeeklyPlan::with('recipes.recipe')->latest()->get();
        $recipeTypes = Recipe::RECIPE_TYPES;
        return view('weekly_plans.index', compact('plans', 'recipeTypes'));
    }
}