@props(['model', 'label' => 'Password', 'showModel'])

@php
    $inputId = 'pw_' . $model;
@endphp

<div class="mb-3 position-relative">
    @if ($label)
        <label class="form-label" for="{{ $inputId }}">{{ $label }}</label>
    @endif

    <div class="input-group">
        <input id="{{ $inputId }}" type="{{ $this->$showModel ? 'text' : 'password' }}"
            wire:model.defer="{{ $model }}" class="form-control transition" placeholder="{{ $label }}"
            required>

        <span class="input-group-text bg-white" role="button" wire:click="$toggle('{{ $showModel }}')">
            <i class="bi {{ $this->$showModel ? 'bi-eye-slash-fill' : 'bi-eye-fill' }}"></i>
        </span>
    </div>

    @error($model)
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>
