@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block pl-3 pr-4 py-2 border-l-4 border-yellow-400 bg-yellow-100 text-base font-medium text-black
       focus:outline-none focus:text-black focus:bg-yellow-150 focus:border-slate-700 transition duration-150 
       ease-in-out rounded-md'
    : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 
       hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 
       focus:border-gray-300 transition duration-150 ease-in-out rounded-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
