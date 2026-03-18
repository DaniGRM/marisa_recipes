<?php

namespace App\Http\Controllers;

use App\Models\TaskInstance;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
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


    public function complete(Task $task)
    {
        $instance = TaskInstance::where('task_id',$task->id)
            ->whereDate('date', now())
            ->where('status','pending')
            ->first();
        $user = Auth::user();
        if($instance){

            $instance->update([
                'status'=>'completed',
                'completed_by'=>$user->id,
                'completed_at'=>now()
            ]);

        }else{

            // Para tareas "common" (shortcut)
            TaskInstance::create([
                'task_id'=>$task->id,
                'date'=>now(),
                'status'=>'completed',
                'completed_by'=>$user->id,
                'completed_at'=>now()
            ]);

        }

        return back();
    }

}