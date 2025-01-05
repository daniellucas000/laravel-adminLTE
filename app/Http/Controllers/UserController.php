<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $d = ['users' => $users];

        return view('users.index', $d);
    }

    public function create()
    {
        $d = ['users' => ''];

        return view('users.create', $d);
    }

    public function store()
    {
        $inputs = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        User::create($inputs);

        return redirect()->route('users.index')->with('status', 'Usuário adicionado com sucesso!');
    }

    public function edit(User $user)
    {
        $user->load('profile', 'interests');
        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        $inputs = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'exclude_if:password,null|min:6'
        ]);

        $user->fill($inputs);
        $user->save();

        return redirect()->route('users.index')->with('status', 'Usuário editado com sucesso!');
    }

    public function updateProfile(User $user)
    {
        $inputs = request()->validate([
            'type' => 'required',
            'address' => 'nullable',
        ]);

        UserProfile::updateOrCreate([
            'user_id' => $user->id,
        ], $inputs);

        return back()->with('status', 'Dados editado com sucesso!');
    }

    public function updateInterests(User $user)
    {
        $inputs = request()->validate([
            'interests' => 'nullable|array',
        ]);

        $user->interests()->delete();

        if (!empty($inputs['interests'])) {
            $user->interests()->createMany($inputs['interests']);
        }

        return back()->with('status', 'Dados editado com sucesso!');
    }

    public function delete(User $user)
    {
        $user->delete();

        return back()->with('status', 'Usuário deletado com sucesso!');
    }
}
