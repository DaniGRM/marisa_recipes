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

            // Calcular la fecha de inicio del período actual
            $periodStartDate = $this->getPeriodStartDate($today, $schedule);

            // Contar instancias generadas en el período actual
            $query = TaskInstance::where('task_id', $task->id);

            if ($task->stackable) {
                // Para stackable: contar por fecha de generación
                $instancesInPeriod = $query->whereBetween('date', [$periodStartDate, $today])->count();
            } else {
                // Para no stackable: contar por fecha de completación
                $instancesInPeriod = $query->whereBetween('completed_at', [$periodStartDate, $today->endOfDay()])->count();
            }

            // Calcular cuántas instancias se deben generar
            $instancesToGenerate = max(0, $schedule->times - $instancesInPeriod);

            // Para tareas no apilables, verificar si hay instancias pendientes
            if (!$task->stackable) {
                $taskActiveCount = TaskInstance::where('task_id', $task->id)->where('status', 'pending')->count();
                if ($taskActiveCount > 0) {
                    $instancesToGenerate = 0;
                }
            }

            if ($instancesToGenerate > 0) {

                // Generar las instancias necesarias
                for ($i = 0; $i < $instancesToGenerate; $i++) {

                    TaskInstance::create([
                        'task_id' => $task->id,
                        'date' => $today,
                        'status' => 'pending'
                    ]);

                }

                $this->info("Generadas {$instancesToGenerate} instancias para tarea {$task->name}");
            }
        }

        return 0;
    }

    /**
     * Calcula la fecha de inicio del período actual basándose en la frecuencia
     * 
     * @param Carbon $today
     * @param TaskSchedule $schedule
     * @return Carbon
     */
    private function getPeriodStartDate(Carbon $today, $schedule)
    {
        $startDate = $today->copy();

        switch ($schedule->frequency) {
            case 'daily':
                $startDate->subDays($schedule->every_n_units - 1);
                break;

            case 'weekly':
                $startDate->subWeeks($schedule->every_n_units - 1);
                break;

            case 'monthly':
                $startDate->subMonths($schedule->every_n_units - 1);
                break;
        }

        return $startDate;
    }
}