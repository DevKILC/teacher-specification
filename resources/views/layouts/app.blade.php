<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Teacher Data Specification</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Font Awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMt23cez/3paNdF+ZVwZODw5ZQ4f+64g7r7IlE" crossorigin="anonymous">

    <!-- Datatable -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/di st/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Vite -->

    <!-- Scripts -->
    @vite(['resources/css/app.css'])

    <!-- Styles -->
    @livewireStyles

</head>

<body class="font-poppins antialiased relative" x-data="{ open: false, loading: false }" x-init="window.addEventListener('beforeunload', () => { loading = true });
window.addEventListener('pageshow', () => { loading = false })"
    :class="{ 'pointer-events-none': loading }">
    <!-- loading line -->
    <div x-show="loading" class="fixed top-0 left-0 w-full z-[1000001]">
        <div class="h-1 bg-blue-500 animate-progress"></div>
    </div>
    <!-- Loading Spinner -->
    <div x-show="loading" x-cloak class="fixed top-4 right-4 z-[1000001]">
        <svg class="animate-spin h-4 w-4  text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
    </div>

    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @if (isset($header))
            <header class="bg-white shadow fixed w-full z-[999]">
                <div class="max-w-7xl mx-auto py-6 px-4 flex flex-row space-x-2 sm:px-6 lg:px-8 items-center">
                    <!-- Toggle Button -->
                    <button @click="open = !open" aria-label="Toggle Sidebar"
                        class="text-gray-500 focus:outline-none pr-7 border-r-2">
                        <!-- Hamburger Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="black">
                            <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                        </svg>
                    </button>
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Sidebar -->
        <x-sidebar />

        <!-- Page Content -->
        <main @click="open = false" class="pt-[90px] pb-[90px]">
            {{ $slot }}
        </main>
    </div>

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- Datatable -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Scripts -->
    <script>
        window.flashMessage = {
            success: "{{ Session::get('success') }}",
            error: "{{ Session::get('error') }}"
        };
    </script>

    @vite(['resources/js/app.js'])
    @livewireScripts

    @stack('scripts')
</body>

</html>
