<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <title>@yield('title')</title>
    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />



    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex">
    <aside class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white flex flex-col justify-between shadow-lg">
        <div>
            <div class="flex items-center justify-center py-1">
                <img class="rounded-full w-16" src="{{ asset('logo.png') }}" alt="Logo">
                <span class="ml-4 text-2xl font-bold text-white-800">Teabliss</span>
            </div>
            <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-gray-700">
            <nav class="space-y-2">
                @yield('navbar')
            </nav>
        </div>

        @auth
            <div class="flex items-center justify-between bg-gray-700 p-4 rounded-t-lg">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('logo.png') }}" class="w-6 h-6 text-green-400 rounded-full" alt="">
                    <span class="font-medium">{{ Auth::user()->name }}</span>
                </div>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="text-red-500 hover:text-red-700" title="Đăng xuất">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10v1M5 19V5a2 2 0 012-2h4" />
                        </svg>
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    <!-- Main Content -->
    <div class="flex-1 ml-64 p-2">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>


</html>
