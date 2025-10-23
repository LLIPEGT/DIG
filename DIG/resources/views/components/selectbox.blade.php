<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-select form-control @if($errors->has($name)) is-invalid @endif"
        @if($disabled ?? false) disabled @endif
        {{ $attributes }}
    >
        <option selected disabled>Selecione...</option>

        @foreach ($data as $item)
            <option value="{{ $item->id }}" @selected($item->id == $select)>
                {{ $item->$field }}
            </option>
        @endforeach
    </select>

    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
