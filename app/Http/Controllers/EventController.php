<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserMonthlyPoint;

class EventController extends Controller
{
    /**
     * Maneja la selección de regalo en flash_moving
     * Suma puntos al usuario y al mes actual
     */
    public function selectGift(Request $request)
    {
        // Validar los datos
        $request->validate([
            'points' => 'required|integer|min:1|max:10'
        ]);

        // Obtener el usuario actual de la sesión
        $userId = $request->input('user_id');
        if (!$userId) {
            return redirect()->route('user.select')->with('error', 'Usuario no seleccionado');
        }

        $points = $request->input('points');
        $now = Carbon::now();

        // Obtener el usuario
        $user = User::findOrFail($userId);

        // Obtener o crear el registro de puntos del mes actual
        $user->addFlashMovingPoints($points);

        // Redirigir de vuelta a la pantalla de cajas
        return back()->with('user' ,$userId)->with('points', $points);
    }
}
