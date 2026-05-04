<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TaskInstance;
use Carbon\Carbon;

class CalculateTaskBonus extends Command
{
    protected $signature = 'tasks:calculate-bonus';
    protected $description = 'Calcula el bonus de las task_instances pendientes según el tiempo transcurrido desde su creación';

    /**
     * Bonus levels based on elapsed periods:
     *   level 1 (>= 1 period)  → +x0.5  (50% of task points)
     *   level 2 (>= 2 periods) → +x1.0  (100% of task points)
     *   level 3 (>= 3 periods) → +x2.0  (200% of task points)
     *
     * Period is derived from the task's schedule (frequency + every_n_units).
     * If there is no schedule, 1 day is used as the period.
     */
    private const LEVELS = [
        // threshold_periods => [multiplier, level]
        3 => [2.0, 3],
        2 => [1.0, 2],
        1 => [0.5, 1],
    ];

    public function handle(): int
    {
        $instances = TaskInstance::with('task.schedule')
            ->where('status', '!=', 'completed')
            ->get();

        $now = Carbon::now();
        $updated = 0;

        foreach ($instances as $instance) {
            $task = $instance->task;
            if (!$task) {
                continue;
            }

            $periodInMinutes = $this->resolvePeriodInMinutes($task->schedule);
            $elapsedMinutes  = $instance->created_at->diffInMinutes($now);
            $elapsedPeriods  = $periodInMinutes > 0 ? $elapsedMinutes / $periodInMinutes : 0;

            [$bonus, $bonusLevel] = $this->calculateBonus($task->points, $elapsedPeriods);

            if ($instance->bonus !== $bonus || $instance->bonus_level !== $bonusLevel) {
                $instance->bonus       = $bonus;
                $instance->bonus_level = $bonusLevel;
                $instance->saveQuietly(); // avoid triggering booted() hooks
                $updated++;
                $this->line(sprintf(
                    'Task instance #%d — task "%s" — elapsed %.2f periods → level %d → bonus %d pts',
                    $instance->id,
                    $task->name,
                    $elapsedPeriods,
                    $bonusLevel,
                    $bonus
                ));
            }
        }

        $this->info("Bonus actualizado en {$updated} instancia(s).");

        return self::SUCCESS;
    }

    /**
     * Resolve the period (in minutes) from the task's schedule.
     * Falls back to 1 day if there is no schedule.
     */
    private function resolvePeriodInMinutes(?\App\Models\TaskSchedule $schedule): int
    {
        if (!$schedule) {
            return 24 * 60; // 1 day
        }

        $n = max(1, (int) ($schedule->every_n_units ?? 1));

        $baseMinutes = match ($schedule->frequency) {
            'daily'   => 24 * 60,
            'weekly'  => 7 * 24 * 60,
            'monthly' => 30 * 24 * 60,
            default   => 24 * 60,
        };

        return $n * $baseMinutes;
    }

    /**
     * Return [bonusPoints, bonusLevel] for the given elapsed periods count.
     * Level 0 means no bonus yet.
     */
    private function calculateBonus(int $points, float $elapsedPeriods): array
    {
        foreach (self::LEVELS as $threshold => [$multiplier, $level]) {
            if ($elapsedPeriods >= $threshold) {
                return [(int) round($points * $multiplier), $level];
            }
        }

        return [0, 0];
    }
}
