<aside
      x-ref="sidebar"
    :class="{ '-translate-x-full': !open }"
    class="sidebar bg-white border-r border-gray-100 h-full w-64 fixed transform transition-transform duration-300 ease-in-out top-0 left-0 z-[1000000] -translate-x-full">

    <!-- Primary Navigation Menu -->
    <div class="flex flex-col justify-between h-full">
        <!-- Logo -->
        <div class="shrink-0 flex items-center justify-between py-4 px-4">
            <a href="{{ route('dashboard') }}">
                <x-application-mark class="block h-9 w-auto" />
            </a>

            <!-- Close Icon -->
            <button @click="open = false" aria-label="Close Sidebar" class="text-gray-500 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-col space-y-4 font-light px-4">
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link href="{{ route('teacher.index') }}" :active="request()->routeIs('teacher.index')">
                {{ __('Teachers Profile') }}
            </x-nav-link>

            <x-nav-link href="{{ route('skill.index') }}" :active="request()->routeIs('skill.index')">
                {{ __('Skills') }}
            </x-nav-link>

            <x-nav-link href="{{ route('record.index') }}" :active="request()->routeIs('record.index')">
                {{ __('Records') }}
            </x-nav-link>
            <x-nav-link href="{{ route('permission.index') }}" :active="request()->segment(1) === 'permission'">
                {{ __('Permission') }}
            </x-nav-link>
            @role('Administrator')
                <x-nav-link href="{{ route('user-management.index') }}" :active="request()->segment(1) === 'user-management'">
                    {{ __('User management') }}
                </x-nav-link>
            @endrole
            {{-- @endcan --}}
        </div>

        <!-- Settings Dropdown -->
        <div class="px-4 py-4 bg-yellow-500 border-t border-gray-200">
            <div class="flex items-center">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 me-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
                @endif

                <div>
                    <div class="font-medium text-base text-[20px] text-slate-100">{{ Auth::user()->name }}</div>
                    <div class="font-light text-[13px] text-slate-100 border-b-slate-50">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('Profile') }}
                </x-dropdown-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                </x-dropdown-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
</aside>