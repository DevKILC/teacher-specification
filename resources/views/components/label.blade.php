@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-left font-medium text-sm text-gray-700 my-5 ']) }}>
    {{ $value ?? $slot }}
</label>
