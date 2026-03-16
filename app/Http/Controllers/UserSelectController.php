<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserSelectController extends Controller
{
    public function index()
    {
        $users = User::whereIn('id', [1,2])->get();

        return view('select-user', compact('users'));
    }

    public function login(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        session(['user_id' => $user->id]);

        return redirect('/');
    }

    public function logout()
    {
        session()->forget('user_id');

        return redirect()->route('user.select');
    }
}