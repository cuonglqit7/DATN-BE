<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white p-5 flex flex-col">
            <h2 class="text-lg font-bold mb-5">Admin Dashboard</h2>
            <nav class="flex flex-col space-y-2">
                <a href="#" class="px-3 py-2 hover:bg-gray-700 rounded">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 bg-gray-700 rounded">Sản phẩm</a>
                <a href="#" class="px-3 py-2 hover:bg-gray-700 rounded">Người dùng</a>
                <a href="#" class="px-3 py-2 hover:bg-gray-700 rounded">Cài đặt</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6 w-full" style="margin-left: 16rem;">
            <div class="flex justify-between items-center bg-white shadow-md rounded-lg p-4 mb-4">
                <div>
                    <h2 class="text-lg font-semibold">Xin chào, Admin!</h2>
                    <p class="text-sm text-gray-600">Chúc bạn một ngày làm việc hiệu quả</p>
                </div>
                @auth
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Đăng xuất</button>
                    </form>
                @endauth
            </div>
            @yield('content')
        </div>
    </div>
</body>



</html>
