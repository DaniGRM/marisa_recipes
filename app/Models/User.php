<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'points'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ['current_month_points', 'current_month_tasks', 'flash_moving_points', 'flash_moving_boxes'];

    public function getCurrentMonthPointsAttribute()
    {
        return $this->monthlyPoints->first()->points ?? 0;
    }

    public function getFlashMovingPointsAttribute()
    {
        return $this->flashMoving->points ?? 0;
    }
    public function getFlashMovingBoxesAttribute()
    {
        return $this->flashMoving->boxes ?? 0;
    }

    public function getCurrentMonthTasksAttribute()
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        return $this->taskInstances()
                    ->where('status', 'completed')
                    ->whereYear('completed_at', $year)
                    ->whereMonth('completed_at', $month)
                    ->count();
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function monthlyPoints()
    {
        return $this->hasMany(UserMonthlyPoint::class);
    }

    public function flashMoving()
    {
        return $this->hasOne(FlashMoving::class);
    }
    public function taskInstances()
    {
        return $this->hasMany(TaskInstance::class, 'completed_by');
    }

    public function getPointsForMonth(Carbon $date = null)
    {
        $date = $date ?? now();

        return $this->monthlyPoints()
            ->where('year', $date->year)
            ->where('month', $date->month)
            ->value('points') ?? 0;
    }
    public function addPoints(int $points)
    {
        $this->points += $points;
        $this->save();

        // Points del mes actual
        $month = now()->month;
        $year = now()->year;

        $monthlyPoints = $this->monthlyPoints()->firstOrCreate(
            ['year' => $year, 'month' => $month],
            ['points' => 0]
        );

        $monthlyPoints->increment('points', $points);
    }

    public function addFlashMovingPoints(int $points)
    {

        $flashMoving = $this->flashMoving()->firstOrCreate(
            ['user_id' => $this->id],
            ['points' => 0, 'boxes' => 0]
        );

        $flashMoving->increment('points', $points);
        $flashMoving->increment('boxes', 1);

        $this->addPoints($points);
    }

    public function completedTasksInMonth(?int $month = null, ?int $year = null): int
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        return $this->taskInstances()
                    ->where('status', 'completed')
                    ->whereYear('completed_at', $year)
                    ->whereMonth('completed_at', $month)
                    ->count();
    }
}
