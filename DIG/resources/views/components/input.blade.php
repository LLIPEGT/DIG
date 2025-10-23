<div class="mb-3">
    <span>
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    </span>

    <div class="input">
        <input
            type="{{ $type ?? 'text' }}"
            class="form-control"
            id="{{ $name }}"
            name="{{ $name }}"
            aria-label="{{ $label }}"
            {{ $attributes }}
        >
    </div>
</div>
