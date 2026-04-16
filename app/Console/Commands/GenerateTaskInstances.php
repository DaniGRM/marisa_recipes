<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\TaskInstance;
use Carbon\Carbon;

class GenerateTaskInstances extends Command
{
    protected $signature = 'tasks:generate';
    protected $description = 'Genera instancias de tareas según su frecuencia';

    public function handle()
    {
        $now = Carbon::now();
        $this->info("Ejecutando generación de tareas para fecha: {$now->toDateTimeString()}");
        $tasks = Task::with('schedule')
            ->where('type', 'frequency')
            ->get();

        foreach ($tasks as $task) {
            $schedule = $task->schedule;
            if (!$schedule) continue;

            if ($task->stackable) {
                $this->handleStackable($task, $schedule, $now);
            } else {
                $this->handleNonStackable($task, $schedule, $now);
            }
        }

        return 0;
    }

    private function handleStackable($task, $schedule, $now)
    {
        $lastInstance = TaskInstance::where('task_id', $task->id)
            ->orderByDesc('date')
            ->first();

        $shouldGenerate = false;

        if (!$lastInstance) {
            $shouldGenerate = true;
        } else {
            $lastDate = Carbon::parse($lastInstance->date);
            
            switch ($schedule->frequency) {
                case 'daily':
                    $shouldGenerate = $lastDate->diffInDays($now) >= $schedule->every_n_units;
                    break;
                case 'weekly':
                    $shouldGenerate = $lastDate->diffInWeeks($now) >= $schedule->every_n_units;
                    break;
                case 'monthly':
                    $shouldGenerate = $lastDate->diffInMonths($now) >= $schedule->every_n_units;
                    break;
            }
        }

        if ($shouldGenerate) {
            for ($i = 0; $i < $schedule->times; $i++) {
                TaskInstance::create([
                    'task_id' => $task->id,
                    'date' => $now,
                    'status' => 'pending'
                ]);
            }
            $this->info("Generadas {$schedule->times} instancias para tarea {$task->name}");
        }
    }

    private function handleNonStackable($task, $schedule, $now)
    {
        $pendingCount = TaskInstance::where('task_id', $task->id)
            ->where('status', 'pending')
            ->count();

        if ($pendingCount > 0) {
            return;
        }

        $lastCompleted = TaskInstance::where('task_id', $task->id)
            ->where('status', 'completed')
            ->orderByDesc('completed_at')
            ->first();

        $shouldGenerate = false;

        if (!$lastCompleted) {
            $shouldGenerate = true;
        } else {
            $completedDate = Carbon::parse($lastCompleted->completed_at);
            $this->info("Tarea: {$task->name},Ahora: {$now->toDateTimeString()}, Última completada: {$completedDate->toDateTimeString()}");
            // Convertir every_n_units a horas según la frecuencia
            $unitsInHours = match($schedule->frequency) {
                'daily' => $schedule->every_n_units * 24,
                'weekly' => $schedule->every_n_units * 24 * 7,
                'monthly' => $schedule->every_n_units * 24 * 30,
                default => 0,
            };

            $intervalHours = $unitsInHours / $schedule->times;
            $hoursPassed = $completedDate->diffInHours($now);
            $this->info("Tarea: {$task->name}, Horas desde última completada: {$hoursPassed}, Intervalo requerido: {$intervalHours}");
            $shouldGenerate = $hoursPassed >= $intervalHours;
        }

        if ($shouldGenerate) {
            TaskInstance::create([
                'task_id' => $task->id,
                'date' => $now,
                'status' => 'pending'
            ]);
            $this->info("Generada 1 instancia para tarea {$task->name}");
        }
    }
}