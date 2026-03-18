<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        Auth::login($user);
        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.select');
    }
}