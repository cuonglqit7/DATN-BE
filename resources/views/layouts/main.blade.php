<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white p-5 flex flex-col justify-between">
            <div>
                <div class="flex flex-col items-center">
                    <img class="h-24 w-48 object-contain mb-2" src="{{ asset('logo.png') }}" alt="">
                    <h2 class="font-bold mb-5">Admin quản trị</h2>
                </div>
                @yield('checked')
            </div>
            @auth
                <form action="{{ route('logout') }}" method="post" class="mt-5">
                    @csrf
                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm w-full">Đăng
                        xuất</button>
                </form>
            @endauth
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-2 w-full" style="margin-left: 16rem;">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>

</html>
