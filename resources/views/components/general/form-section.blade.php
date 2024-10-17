<div {{ $attributes->merge(['class' => '']) }}>
    <div class="mt-5 md:mt-0 md:col-span-2 w-full">
        <!-- Form with dynamic action -->
        <form action="{{ $attributes->get('submit') }}" method="POST">
            @csrf
            <!-- Form Content -->
            <div class="px-4 w-full py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-6 gap-6 w-full">
                    <!-- Ensure full width by using col-span-6 for all form fields -->
                    <div class="col-span-6">
                        {{ $form }}
                    </div>
                </div>
            </div>

            <!-- Form Actions (optional) -->
            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
