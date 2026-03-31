<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskInstance extends Model
{
    protected $fillable = [
        'task_id',
        'date',
        'status',
        'completed_by',
        'completed_at'
    ];

    protected $casts = [
        'date' => 'date',
        'completed_at' => 'datetime'
    ];

    protected static function booted()
    {
        static::saving(function ($taskInstance) {

            // Solo si se marca como completed
            if ($taskInstance->status !== 'completed') {
                return;
            }

            // 🔴 CLAVE: evitar duplicados
            // Si ya estaba completada antes, no sumar otra vez
            if ($taskInstance->exists) {
                $originalStatus = $taskInstance->getOriginal('status');

                if ($originalStatus === 'completed') {
                    return;
                }
            }
            $task = $taskInstance->task;

            if (!$task) {
                return;
            }
            if($task->linkedTasks->count() > 0) {
                foreach ($task->linkedTasks as $linkedTask) {
                    TaskInstance::create([
                        'task_id'=>$linkedTask->id,
                        'date'=>now(),
                        'status'=>'pending'
                    ]);
                }
            }

            $user = \App\Models\User::find($taskInstance->completed_by);

            if (!$user) {
                return;
            }

            // Sumar puntos
            $user->increment('points', $task->points);
            $user->addPoints($task->points);
        });
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}