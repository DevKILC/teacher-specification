@props(['open' => false, 'title' => 'Modal Title'])

<div x-show="{{ $open }}" @click.away="{{ $open }} = false" class="fixed inset-0 flex items-center justify-center z-50" x-cloak>
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b pb-2 mb-4">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ $title }}
            </h2>
            <button @click="{{ $open }} = false" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 96 960 960" width="24" fill="black">
                    <path d="M720 936 528 744 336 936l-72-72 192-192-192-192 72-72 192 192 192-192 72 72-192 192 192 192-72 72Z"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        {{ $slot }}
    </div>
</div>