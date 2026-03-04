@props(['label' => null, 'name' => null, 'checked' => false])

<div class="flex items-center {{ $attributes->get('class') }}">
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="checkbox"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'h-4 w-4 text-blue-600 border-gray-300 rounded']) }} />

    @if($label)
    <label for="{{ $name }}" class="ml-2 block text-sm text-gray-700">{{ $label }}</label>
    @endif

    @if ($errors->has($name))
    <p class="text-sm text-red-600 mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>