<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weekly_plan_recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_plan_id')
                ->constrained('weekly_plans')
                ->onDelete('cascade');

            $table->foreignId('recipe_id')
                ->constrained('recipes')
                ->onDelete('cascade');

            $table->tinyInteger('slot'); // 0,1,2
            $table->enum('type', ['weekly','single']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_plan_recipes');
    }
};
