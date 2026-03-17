<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSchedule extends Model
{
    protected $fillable = [
        'task_id',
        'frequency',
        'times',
        'every_n_units',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}