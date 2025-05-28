@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'class' => '',
])

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="block mb-1 text-sm font-medium text-gray-700">
            {{ $label }}@if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($readonly) readonly @endif
        {{ $attributes->merge(['class' => 'w-full p-2 border border-gray-300 rounded ' . $class]) }}
    />
</div>
