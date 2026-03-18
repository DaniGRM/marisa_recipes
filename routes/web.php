<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\WeeklyPlanController;
use App\Http\Controllers\UserSelectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskInstanceController;

Route::get('/select-user', [UserSelectController::class, 'index'])->name('user.select');
Route::post('/select-user', [UserSelectController::class, 'login'])->name('user.login');
Route::post('/logout', [UserSelectController::class, 'logout'])->name('user.logout');

Route::middleware('user.selected')->group(function () {
    Route::get('/', [MainController::class, 'index'])
        ->name('welcome');

    Route::get('/recipes', [RecipeController::class, 'index'])
        ->name('recipes.index');

    Route::post('/recipes', [RecipeController::class, 'store'])
        ->name('recipes.store');

    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])
        ->name('recipes.update');

    Route::get('/weekly-plans', [WeeklyPlanController::class, 'index'])->name('weekly_plans.index');
    Route::post('/weekly-plans/generate', [WeeklyPlanController::class, 'generate'])->name('weekly_plans.generate');

    Route::get('/tasks', [TaskController::class,'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class,'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class,'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class,'destroy'])->name('tasks.destroy');

    Route::get('/today', [TaskInstanceController::class,'today'])->name('tasks.today');
    Route::post('/tasks/{task}/complete', [TaskInstanceController::class,'complete'])->name('tasks.complete');
    Route::post('/tasks/{task}/complete-common', [TaskInstanceController::class,'completeCommon'])->name('tasks.complete-cpmmon');
});