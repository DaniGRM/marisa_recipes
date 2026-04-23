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
        // Siempre obtener los dos usuarios
        $users = User::whereIn('id', [1,2])
            ->with(['monthlyPoints' => function ($q) use ($now) {
                $q->where('year', $now->year)
                ->where('month', $now->month);
            }])
            ->with(['flashMoving'])
            ->get();
        
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

        // Obtener el filtro de cada usuario desde la sesión
        $userFilters = [];
        $userFilters[1] = session("bmo_filter_user_1");
        $userFilters[2] = session("bmo_filter_user_2");

        // El filtro actual es el que corresponde al currentUser (puede ser null si no hay currentUser)
        $currentFilter = $userFilters[$currentUser] ?? null;


        $winningRooms = $this->getWinningRooms($rooms);

        
        // Pasar el array de usuarios completo siempre, independientemente del currentUser
        return view('bmo2.index', compact(
            'tasks',
            'totalPoints', 
            'users',  // Siempre se pasa el array de usuarios
            'currentUser', 
            'commonTasks', 
            'taskCompleted', 
            'rooms', 
            'currentFilter',
            'userFilters',  // Array con los filtros de ambos usuarios
            'winningRooms'
        ));
    }

    /**
     * Guarda el filtro de habitación en sesión
     */
    public function saveFilter(Request $request)
    {
        $request->validate([
            'room' => 'nullable|string',
            'user_id' => 'required|in:1,2'
        ]);

        $userId = $request->input('user_id');
        $room = $request->input('room');

        if ($room === null || $room === '') {
            // Limpiar el filtro si es nulo o vacío
            session()->forget("bmo_filter_user_{$userId}");
        } else {
            // Guardar el filtro en sesión
            session(["bmo_filter_user_{$userId}" => $room]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Filtro guardado correctamente',
            'room' => $room
        ]);
    }

    private function getWinningRooms($rooms){
        $roomsByUser = [];

        foreach ([1, 2] as $userId) {
            $roomsByUser[$userId] = TaskInstance::where('completed_by', $userId)
                ->where('status', 'completed')
                ->with('task')
                ->get()
                ->groupBy(fn($ti) => $ti->task?->room_id)
                ->map(fn($group) => $group->count());
        }

        // Obtener todas las room_ids presentes
        $allRoomIds = collect($roomsByUser[1])
            ->keys()
            ->merge($roomsByUser[2]->keys())
            ->unique();

        $winningRooms = [
            1 => [],
            2 => []
        ];

        foreach ($allRoomIds as $roomId) {
            if (is_null($roomId)) continue;

            $count1 = $roomsByUser[1][$roomId] ?? 0;
            $count2 = $roomsByUser[2][$roomId] ?? 0;

            if ($count1 > $count2) {
                $winningRooms[1][] = $rooms->firstWhere('id', $roomId);
            } elseif ($count2 > $count1) {
                $winningRooms[2][] = $rooms->firstWhere('id', $roomId);
            }
        }

        return $winningRooms;
    }
}