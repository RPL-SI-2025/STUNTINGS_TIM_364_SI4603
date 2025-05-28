@props([
    'label' => null,
    'name',
    'options' => [],
    'selected' => null,
    'class' => '',
    'required' => false,
])

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="block mb-1 text-sm font-medium text-gray-700">
            {{ $label }}@if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full p-2 border border-gray-300 rounded ' . $class]) }}
    >
        <option value="" disabled {{ $selected ? '' : 'selected' }}>Pilih {{ strtolower($label ?? $name) }}</option>
        @foreach ($options as $value => $display)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $display }}</option>
        @endforeach
    </select>
</div>
