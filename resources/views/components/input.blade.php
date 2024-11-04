@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} 
    x-on:input="$event.target.value = $event.target.value.toUpperCase()"
    {!! $attributes->merge(['class' => 'border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm']) !!}>
