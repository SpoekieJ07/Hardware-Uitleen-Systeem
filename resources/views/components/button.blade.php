@props(['type' => 'primary', 'buttonType' => 'submit'])

@php
// basic tailwind button variants, feel free to customize
$base = 'px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 ';

if ($type === 'primary') {
$base .= 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white';
} elseif ($type === 'secondary') {
$base .= 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white';
} else {
// default/neutral
$base .= 'bg-gray-200 hover:bg-gray-300 text-gray-800';
}
@endphp

<button type="{{ $buttonType }}" {{ $attributes->merge(['class' => $base]) }}>
    {{ $slot }}
</button>