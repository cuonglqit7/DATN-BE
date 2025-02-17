<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tea Bliss Auth')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-500 p-4 text-white">
        <div class="container mx-auto flex justify-between">
            <a href="/" class="font-bold">Trang Chủ</a>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:underline">Đăng Xuất</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline">Đăng Nhập</a>
            @endauth
        </div>
    </nav>
    <div class="container mx-auto p-4">
        @yield('content')
    </div>
</body>

</html>
