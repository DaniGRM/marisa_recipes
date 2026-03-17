<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'points'
    ];

    public function schedule()
    {
        return $this->hasOne(TaskSchedule::class);
    }

    public function instances()
    {
        return $this->hasMany(TaskInstance::class);
    }
}