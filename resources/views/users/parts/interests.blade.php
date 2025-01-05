<div class="card">
    <form action="{{ route('users.updateInterests', $user->id )}}" method="post">
        @csrf
        @method('PUT')
        <div class="card-header">
            Interesses
        </div>
        <div class="card-body">
            @foreach (['Futebol', 'Fórmula 1'] as $item )
            <div class="form-check">
                <input
                    class="form-check-input @error('interests') is-invalid @enderror"
                    type="checkbox"
                    value="{{$item}}"
                    name="interests[][name]"
                    @checked(in_array($item, $user->interests->pluck('name')->toArray()))>
                <label class="form-check-label">
                    {{$item}}
                </label>
                @if ($loop->last)
                @error('interests')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                @endif
            </div>
            @endforeach
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Editar</button>
        </div>
    </form>
</div>