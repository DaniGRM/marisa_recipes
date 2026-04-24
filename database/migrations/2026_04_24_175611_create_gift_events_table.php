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
        Schema::create('gift_events', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            // Pistas
            $table->string('hint_text')->nullable();
            $table->string('hint_image')->nullable();
            $table->string('hint_sound')->nullable();

            // Puntos base
            $table->integer('base_points')->default(30);

            $table->timestamps();
        });

        Schema::create('user_gift_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('gift_event_id')->constrained()->cascadeOnDelete();

            // Estado de pistas usadas
            $table->boolean('used_text')->default(false);
            $table->boolean('used_image')->default(false);
            $table->boolean('used_sound')->default(false);

            // Resultado
            $table->boolean('completed')->default(false);
            $table->integer('points_earned')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'gift_event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_events');
    }
};
