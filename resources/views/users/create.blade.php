@extends('layouts.default')
@section('page-title', 'Adicionar usuário')
@section('content')
<form action="{{route('users.store')}}" method="post">
    @csrf
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input
            type="text"
            value="{{old('name')}}"
            class="form-control @error('name') is-invalid @enderror"
            name="name">
        @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input
            type="text"
            value="{{old('email')}}"
            class="form-control @error('email') is-invalid @enderror"
            name="email">
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input
            type="text"
            class="form-control @error('password') is-invalid @enderror"
            name="password">
        @error('password')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">To add</button>
</form>
@endsection