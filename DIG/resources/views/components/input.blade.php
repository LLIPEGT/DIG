{{-- resources/views/components/input.blade.php --}}
<div class="mb-3 position-relative">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>

    @isset($icon)
        <i class="bi bi-{{ $icon }} form-icon"></i>
    @endisset

    <input
        type="{{ $type ?? 'text' }}"
        class="form-control form-control-with-icon"
        id="{{ $name }}"
        name="{{ $name }}"
        aria-label="{{ $label }}"
        {{ $attributes }}
    >
</div>
