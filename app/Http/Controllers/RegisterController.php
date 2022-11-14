<?php

namespace App\Http\Controllers;

use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('create_user');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required','max:255'],
            'username' => ['required','min:4','max:255','unique:users,username'],
            'email' => ['required','email','max:255','unique:users','email'],
            'password' => ['required','min:4','max:255']
        ]);

        auth()->login(User::create($attributes));

        return redirect('/')->with('success', 'Your account has been created.');
    }
}
