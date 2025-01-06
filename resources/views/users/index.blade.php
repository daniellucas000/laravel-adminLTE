@extends('layouts.default')
@section('page-title', 'Usuários')
@section('page-actions')
<a href="{{route('users.create')}}" class="btn btn-primary">Adicionar usuário</a>
@endsection
@section('content')
@session('status')
<div class="alert alert-success">
    {{$value}}
</div>
@endsession

<form action="{{ route('users.index') }}" method="get" class="mb-3" style="width: 300px;">
    <div class="input-group input-group-sm">
        <input
            value="{{ request()?->keyword}}"
            type="text"
            name="q"
            class="form-control"
            placeholder="Pesquise por nome ou email">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td class="d-flex gap-2">
                @can('edit', \App\Models\User::class)
                <a href="{{ route('users.edit', $user->id)}}" class="btn btn-primary btn-sm">Editar</a>
                @endcan
                @can('delete', \App\Models\User::class)
                <form action="{{ route('users.delete', $user->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Excluir</button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$users->links()}}
@endsection