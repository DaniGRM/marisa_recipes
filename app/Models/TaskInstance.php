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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}