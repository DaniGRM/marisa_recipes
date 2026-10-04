<?php

namespace App\Http\Controllers;

use App\Models\Punishment;
use Illuminate\Http\Request;

class PunishmentController extends Controller
{
    public function index()
    {
        $punishments = Punishment::orderBy('name')->get();

        return view('punishments.index', compact('punishments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Punishment::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('punishments.index');
    }

    public function update(Request $request, Punishment $punishment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $punishment->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('punishments.index');
    }

    public function destroy(Punishment $punishment)
    {
        $punishment->delete();

        return redirect()->route('punishments.index');
    }
}
