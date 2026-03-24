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
        Schema::table('tasks', function (Blueprint $table) {

            // añadir nuevo tipo al enum (depende de cómo lo tengas)
            $table->enum('type', ['common', 'frequency', 'unique', 'linked'])->change();

            // relación a tarea padre
            $table->foreignId('linked_task_id')
                ->nullable()
                ->constrained('tasks')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('linked_task_id');
        });
    }
};
