<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSchedule;
use Illuminate\Http\Request;
use App\Models\Room;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with(['linkedTasks.linkedTasks'])->with('schedule')->get();

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
        $rooms = Room::pluck('name');
        return view('tasks.index', compact('tasks','types','frequencies', 'rooms'));
    }

    public function store(Request $request)
    {
        $roomInput = ucfirst(strtolower(trim($request->room)));

        // Buscar o crear
        $room = Room::firstOrCreate([
            'name' => trim($roomInput)
        ]);

        $linkedTaskId = $request->linked_task_id;

        $type = $linkedTaskId ? 'linked' : $request->type;
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $type,
            'points' => $request->points,
            'room_id' => $room->id,
        ]);

        if($linkedTaskId){
            $task->linked_task_id = $linkedTaskId;
        }
        $task->save();
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
        $roomInput = ucfirst(strtolower(trim($request->room)));

        $room = Room::firstOrCreate([
            'name' => $roomInput
        ]);

        $task->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'type'=>$task->linked_task_id ? 'linked' : $request->type,
            'points' => $request->points,
            'room_id' => $room->id,
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