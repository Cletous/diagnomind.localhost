@props(['type' => 'text', 'model', 'label' => null, 'readonly' => false])

<div class="mb-3">
    @if ($label)
        <label class="form-label">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" wire:model.defer="{{ $model }}" class="form-control"
        placeholder="{{ $label ?? ucfirst($model) }}" @if ($readonly) readonly @endif required>
    @error($model)
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>
