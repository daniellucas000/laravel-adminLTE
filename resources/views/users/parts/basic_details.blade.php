<div class="card">
    <form action="{{ route('users.update', $user->id )}}" method="post">
        @csrf
        @method('PUT')
        <div class="card-header">
            Dados básicos
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    value="{{old('name') ?? $user->name }}"
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
                    value="{{old('email') ?? $user->email }}"
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
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Editar</button>
        </div>
    </form>
</div>