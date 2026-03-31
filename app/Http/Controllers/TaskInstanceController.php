<?php

namespace App\Http\Controllers;

use App\Models\TaskInstance;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class TaskInstanceController extends Controller
{

    public function today()
    {
        $today = now()->toDateString();

        $tasks = TaskInstance::with('task')
            ->where('date', $today)
            ->whereDate('completed_at', $today)
            ->get();

        $commonTasks = Task::where('type', 'common')->get();
        $user = Auth::getUser();
        // $totalPoints = $user->points;
        $totalPoints = 0;

        return view('tasks.today', compact('tasks','totalPoints', 'commonTasks'));
    }


    public function complete(Request $request, Task $task)
    {
        $instance = TaskInstance::where('task_id',$task->id)
            ->where('status','pending')
            ->first();
        if(isset($request['user'])){
            $userId = $request['user'];
        }else{
            $user = Auth::user();
            $userId = $user->id;
        }
        if($instance){

            $instance->update([
                'status'=>'completed',
                'completed_by'=>$userId,
                'completed_at'=>now()
            ]);

        }else{

            // Para tareas "common" (shortcut)
            $instance =TaskInstance::create([
                'task_id'=>$task->id,
                'date'=>now(),
                'status'=>'completed',
                'completed_by'=>$userId,
                'completed_at'=>now()
            ]);

        }

        return back()->with('user' ,$userId)->with('task_completed', $instance);
    }

    public function todayBmo()
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

        return view('bmo.index', compact('tasks','totalPoints', 'users', 'currentUser', 'commonTasks', 'taskCompleted'));
    }

}