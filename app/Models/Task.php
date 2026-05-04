<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

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

    protected static function booted(): void
    {
        static::saved(function () {
            Artisan::call('tasks:generate');
        });
    }

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