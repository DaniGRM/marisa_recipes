<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE task_instances MODIFY COLUMN status ENUM('pending', 'completed', 'skipped', 'rejected') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE task_instances MODIFY COLUMN status ENUM('pending', 'completed', 'skipped') NOT NULL DEFAULT 'pending'");
    }
};
