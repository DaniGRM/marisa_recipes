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
            ->whereDate('date', now())
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
            TaskInstance::create([
                'task_id'=>$task->id,
                'date'=>now(),
                'status'=>'completed',
                'completed_by'=>$userId,
                'completed_at'=>now()
            ]);

        }

        return back()->with('user' ,$userId);
    }

    public function todayBmo()
    {
        $currentUser = 0;
        $sessionUser = session('user');
        if($sessionUser){
            $currentUser = $sessionUser;
        }
        $users = User::whereIn('id', [1,2])->get();
        $today = now()->toDateString();

        $tasks = TaskInstance::with('task')
            ->where('date', $today)
            ->orWhere('status','pending')
            ->orderBy('status', 'asc')
            ->get();
        $commonTasks = Task::where('type', 'common')->get();
        $totalPoints = $tasks
            ->where('status','completed')
            ->sum(fn($t) => $t->task->points);

        return view('bmo.index', compact('tasks','totalPoints', 'users', 'currentUser', 'commonTasks'));
    }

}