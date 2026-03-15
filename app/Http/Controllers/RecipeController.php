<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;

class RecipeController extends Controller
{
    public function index()
    {
        // De momento datos simulados
        $recipes = Recipe::with('ingredients')->get();
        foreach($recipes as $recipe){
            $ingredients = $recipe->ingredients;
        }
        $ingredients = Ingredient::all();
        $recipeTypes = Recipe::RECIPE_TYPES;

        return view('recipes.index', compact('recipes','ingredients', 'recipeTypes'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|integer',
            'weekly' => 'nullable|boolean',
            'ingredients' => 'nullable|array'
        ]);

        $recipe = Recipe::create([
            'name' => $request->name,
            'type' => $request->type,
            'weekly' => $request->has('weekly')
        ]);

        $ingredientIds = [];

        if ($request->ingredients) {

            foreach ($request->ingredients as $ingredientName) {

                $ingredient = Ingredient::firstOrCreate([
                    'name' => trim($ingredientName)
                ]);

                $ingredientIds[] = $ingredient->id;
            }

            $recipe->ingredients()->sync($ingredientIds);
        }

        return redirect()->route('recipes.index');
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|integer',
            'ingredients' => 'nullable|array'
        ]);

        $recipe->update([
            'name' => $request->name,
            'type' => $request->type,
            'weekly' => $request->has('weekly')
        ]);

        $ingredientIds = [];

        if ($request->ingredients) {

            foreach ($request->ingredients as $ingredientName) {

                $ingredient = Ingredient::firstOrCreate([
                    'name' => trim($ingredientName)
                ]);

                $ingredientIds[] = $ingredient->id;
            }
        }

        $recipe->ingredients()->sync($ingredientIds);

        return redirect()->route('recipes.index');
    }
}