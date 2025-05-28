@props([
    'type' => 'submit',
    'href' => null,
    'formaction' => null,
    'class' => '',
])

@php
$defaultClass = 'bg-[#005f77] hover:bg-[#014f66] text-white font-semibold text-sm rounded-md px-4 py-2 transition';
@endphp

@if ($href)
    <a href="{{ $href }}" class="{{ $defaultClass }} {{ $class }}">
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @if ($formaction) formaction="{{ $formaction }}" @endif
        class="{{ $defaultClass }} {{ $class }}">
        {{ $slot }}
    </button>
@endif
