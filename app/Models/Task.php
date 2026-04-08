<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'points',
        'room_id',
        'stackable',
    ];

    public function schedule()
    {
        return $this->hasOne(TaskSchedule::class);
    }

    public function instances()
    {
        return $this->hasMany(TaskInstance::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'linked_task_id');
    }

    public function linkedTasks()
    {
        return $this->hasMany(Task::class, 'linked_task_id');
    }
}