<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query(10);
        $users->when(request()->q, function ($query, $q) {
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%');
            });
        });

        $users = $users->paginate();
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
        Gate::authorize('edit', User::class);
        $user->load('profile', 'interests');
        $roles = Role::all();

        $d = [
            'user' => $user,
            'roles' => $roles
        ];

        return view('users.edit', $d);
    }

    public function update(User $user)
    {
        Gate::authorize('edit', User::class);
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
        Gate::authorize('edit', User::class);
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
        Gate::authorize('edit', User::class);

        $inputs = request()->validate([
            'interests' => 'nullable|array',
        ]);

        $user->interests()->delete();

        if (!empty($inputs['interests'])) {
            $user->interests()->createMany($inputs['interests']);
        }

        return back()->with('status', 'Dados editado com sucesso!');
    }

    public function updateRoles(User $user)
    {
        Gate::authorize('edit', User::class);

        $inputs = request()->validate([
            'roles' => 'required|array',
        ]);

        $user->roles()->sync($inputs['roles']);

        return back()->with('status', 'Dados editado com sucesso!');
    }

    public function delete(User $user)
    {
        Gate::authorize('delete', User::class);

        $user->delete();

        return back()->with('status', 'Usuário deletado com sucesso!');
    }
}
