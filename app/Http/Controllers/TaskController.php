<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSchedule;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with('schedule')->get();

        $types = [
            'common' => 'Común',
            'frequency' => 'Frecuencia',
            'unique' => 'Única'
        ];

        $frequencies = [
            'daily' => 'Día(s)',
            'weekly' => 'Semana(s)',
            'monthly' => 'Mes(es)'
        ];

        return view('tasks.index', compact('tasks','types','frequencies'));
    }

    public function store(Request $request)
    {

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'points' => $request->points
        ]);

        if($request->type === 'frequency'){

            TaskSchedule::create([
                'task_id' => $task->id,
                'frequency' => $request->frequency,
                'times' => $request->times,
                'every_n_units' => $request->every_n_units,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

        }

        return redirect()->route('tasks.index');
    }

    public function update(Request $request, Task $task)
    {

        $task->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'type'=>$request->type,
            'points' => $request->points
        ]);

        if($task->type === 'frequency'){

            $task->schedule()->updateOrCreate(
                ['task_id'=>$task->id],
                [
                    'frequency'=>$request->frequency,
                    'times'=>$request->times,
                    'every_n_units'=>$request->every_n_units,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date
                ]
            );

        }

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }

}