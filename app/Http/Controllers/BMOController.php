<?php

namespace App\Http\Controllers;

use App\Models\TaskInstance;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Room;

class BMOController extends Controller
{
    public function bmo()
    {
        $currentUser = 0;
        $sessionUser = session('user');
        if($sessionUser){
            $currentUser = $sessionUser;
        }
        $taskCompleted = session('task_completed');
        if($taskCompleted){
            session()->forget('task_completed');
        }
        
        $now = Carbon::now();
        $users = User::whereIn('id', [1,2])
            ->with(['monthlyPoints' => function ($q) use ($now) {
            $q->where('year', $now->year)
            ->where('month', $now->month);
        }])->get();
        $today = now()->toDateString();

        $tasks = TaskInstance::with('task')
            ->where('date', $today)
            ->orWhereDate('completed_at', $today)
            ->orWhere('status','pending')
            ->orderBy('status', 'asc')
            ->get();
        $commonTasks = Task::where('type', 'common')->get();
        $totalPoints = $tasks
            ->where('status','completed')
            ->sum(fn($t) => $t->task->points);
        $rooms = Room::all();
        return view('bmo2.index', compact('tasks','totalPoints', 'users', 'currentUser', 'commonTasks', 'taskCompleted', 'rooms'));
    }

}