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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['common', 'frequency', 'unique']);
            $table->timestamps();
        });

        Schema::create('task_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');

            $table->enum('frequency', ['daily', 'weekly', 'monthly'])->nullable(); // null si es única
            $table->unsignedInteger('times')->nullable();         // e.g. 2 veces por semana
            $table->unsignedInteger('every_n_units')->nullable(); // e.g. cada 3 días
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();   

            $table->timestamps();
        });

        Schema::create('task_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');

            $table->date('date');
            $table->enum('status', ['pending', 'completed', 'skipped'])->default('pending');

            $table->foreignId('completed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_schedules');
        Schema::dropIfExists('task_instances');
    }
};
