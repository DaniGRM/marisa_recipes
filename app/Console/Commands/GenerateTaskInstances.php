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
        $today = Carbon::today();

        $tasks = Task::with('schedule')
            ->where('type', 'frequency')
            ->get();

        foreach ($tasks as $task) {

            $schedule = $task->schedule;

            if (!$schedule) continue;

            if($schedule->start_date && $schedule->start_date > $today) continue;
            // Última vez que se generó
            $lastInstance = TaskInstance::where('task_id', $task->id)
                ->orderByDesc('date')
                ->first();
            $lastDate = null;
            if(!$lastInstance){
                if($schedule->start_date){
                    $lastDate = Carbon::parse($schedule->start_date ?? $today);
                }
            }else{
                $lastDate = Carbon::parse($lastInstance->date);
            }
            // Calcular diferencia según frecuencia
            $shouldGenerate = false;
            if(!$lastDate){
                $shouldGenerate = true;
            }else{
                switch ($schedule->frequency) {

                    case 'daily':
                        $shouldGenerate = $lastDate->diffInDays($today) >= $schedule->every_n_units;
                        break;

                    case 'weekly':
                        $shouldGenerate = $lastDate->diffInWeeks($today) >= $schedule->every_n_units;
                        break;

                    case 'monthly':
                        $shouldGenerate = $lastDate->diffInMonths($today) >= $schedule->every_n_units;
                        break;
                }
            }
            

            if ($shouldGenerate) {

                // Generar tantas veces como "times"
                for ($i = 0; $i < $schedule->times; $i++) {

                    TaskInstance::create([
                        'task_id' => $task->id,
                        'date' => $today,
                        'status' => 'pending'
                    ]);

                }

                $this->info("Generadas {$schedule->times} instancias para tarea {$task->name}");
            }
        }

        return 0;
    }
}