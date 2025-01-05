<div class="card">
    <form action="{{ route('users.updateProfile', $user->id )}}" method="post">
        @csrf
        @method('PUT')
        <div class="card-header">
            Perfil
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Tipo de pessoa</label>
                <select name="type" class="form-control @error('type') is-invalid @enderror">
                    @foreach ([['name' => 'Pessoa Física', 'label' => 'PF'], ['name' => 'Pessoa Jurídica', 'label' => 'PJ']] as $type)
                    <option
                        value="{{ $type['label'] }}"
                        @selected(old('type')===$type['label'] || ($user?->profile?->type === $type['label']))
                        >
                        {{ $type['name'] }}
                    </option>
                    @endforeach

                </select>
                @error('type')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input
                    type="text"
                    class="form-control @error('address') is-invalid @enderror"
                    name="address"
                    value="{{old('address') ?? $user?->profile?->address }}">
                @error('address')
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