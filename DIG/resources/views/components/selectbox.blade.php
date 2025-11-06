<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-select @error($name) is-invalid @enderror">
        <option value="">Selecione...</option>
        @foreach($data as $item)
            <option value="{{ $item->id }}" {{ $select == $item->id ? 'selected' : '' }}>
                {{ $item->$field }}
            </option>
        @endforeach
    </select>
</div>
