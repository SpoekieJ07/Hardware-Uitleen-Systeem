@props(['label' => null, 'name' => null, 'type' => 'text', 'placeholder' => null])

<div {{ $attributes->get('wrapper') ?? '' }}>
    @if($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm']) }} />

    @if ($errors->has($name))
    <p class="text-sm text-red-600 mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>