@props(['active'])

<nav class="flex flex-col space-y-2 bg-gray-800 p-4 rounded-lg text-white w-64">
    <!-- Dashboard -->
    <a href="{{ route('home') }}"
        class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200
               {{ $active === 'home' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0 0h4m-4 0a2 2 0 01-2-2V9m6 11a2 2 0 002-2v-6" />
        </svg>
        Dashboard
    </a>

    <!-- Sản phẩm -->
    <a href="{{ route('products.index') }}"
        class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200
               {{ $active === 'product' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
        </svg>
        Sản phẩm
    </a>

    <!-- Danh mục Dropdown -->
    <div class="relative group">
        <a href="#"
            class="flex items-center justify-between px-3 py-2 rounded text-sm cursor-pointer transition-all duration-200
                   {{ $active === 'category' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                Danh mục
            </span>
            <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </a>

        <!-- Dropdown Content -->
        <div class="absolute left-0 hidden group-hover:block bg-gray-800 rounded pt-1 p-1 w-full shadow-lg z-10">
            <a href="{{ route('categories.index') }}"
                class="block px-3 py-2 hover:bg-gray-700 rounded text-sm transition-all">Sản phẩm</a>
            <a href="#" class="block px-3 py-2 hover:bg-gray-700 rounded text-sm transition-all">Bài viết</a>
        </div>
    </div>

    <!-- Other Menu Items -->
    <a href="#"
        class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200
               {{ $active === 'order' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v6H3z M3 9v12h18V9" />
        </svg>
        Đơn hàng
    </a>

    <a href="#"
        class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200
               {{ $active === 'comment' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 8h2a2 2 0 012 2v7a2 2 0 01-2 2h-6l-4 4v-4H7a2 2 0 01-2-2v-7a2 2 0 012-2h2" />
        </svg>
        Bình luận
    </a>

    <a href="#"
        class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200
               {{ $active === 'promo' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8V4m0 0a8 8 0 11-8 8h4" />
        </svg>
        Khuyến mãi
    </a>

    <a href="{{ route('users.index') }}"
        class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200
               {{ $active === 'user' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A12.937 12.937 0 0112 15c2.489 0 4.804.733 6.879 1.984M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Khách hàng
    </a>

    <a href="{{ route('roles.index') }}"
        class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200
               {{ $active === 'role' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        Quyền hạng
    </a>
</nav>
