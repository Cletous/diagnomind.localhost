@props(['model', 'label' => 'Password', 'showModel'])

<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <input type="{{ $this->$showModel ? 'text' : 'password' }}" wire:model.defer="{{ $model }}" class="form-control"
        placeholder="{{ $label }}" required>

    @error($model)
        <div class="text-danger small">{{ $message }}</div>
    @enderror

    <div class="form-check mt-2">
        <input type="checkbox" class="form-check-input" wire:model.live.debounce.10ms="{{ $showModel }}"
            id="toggle_{{ $model }}">
        <label class="form-check-label" for="toggle_{{ $model }}">Show password</label>
    </div>
</div>
