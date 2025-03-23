@props(['active'])
<aside class="fixed top-0 left-0 h-full w-64 bg-white text-gray-900 flex flex-col justify-between shadow-lg">
    <div>
        <div class="flex items-center justify-start px-4 py-2.5 gap-2">
            <img class="rounded-full w-8" src="{{ asset('logo.png') }}" alt="Logo">
            <span class="text-2xl font-bold text-black-800">Teabliss</span>
        </div>
        <hr class="h-px bg-gray-200 border-0">

        <nav class="flex flex-col space-y-2 p-4 rounded-lg text-gray-900 bg-white w-64">
            <!-- Dashboard -->
            <a href="{{ route('home') }}"
                class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                       {{ $active === 'home' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                </svg>
                Dashboard
            </a>

            <!-- Sản phẩm -->
            <a href="{{ route('products.index') }}"
                class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                       {{ $active === 'product' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                        d="M10 12v1h4v-1m4 7H6a1 1 0 0 1-1-1V9h14v9a1 1 0 0 1-1 1ZM4 5h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                </svg>

                Sản phẩm
            </a>

            <!-- Danh mục Dropdown -->
            <div class="relative group">
                <a href="#"
                    class="flex items-center justify-between px-3 py-2 rounded text-sm cursor-pointer transition-all duration-200 gap-2
                           {{ $active === 'category' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m17 21-5-4-5 4V3.889a.92.92 0 0 1 .244-.629.808.808 0 0 1 .59-.26h8.333a.81.81 0 0 1 .589.26.92.92 0 0 1 .244.63V21Z" />
                        </svg>
                        Danh mục
                    </span>
                    <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>

                <!-- Dropdown Content -->
                <div class="absolute left-0 hidden group-hover:block bg-white rounded pt-1 p-1 w-full shadow-lg z-10">
                    <a href="{{ route('categories.index') }}"
                        class="block px-3 py-2 hover:bg-gray-200 rounded text-sm transition-all text-gray-900">Sản
                        phẩm</a>
                    <a href="{{ route('articleCategories.index') }}"
                        class="block px-3 py-2 hover:bg-gray-200 rounded text-sm transition-all text-gray-900">Bài
                        viết</a>
                </div>
            </div>

            <!-- Bài viết -->
            <a href="{{ route('articles.index') }}"
                class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                       {{ $active === 'article' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                </svg>

                Bài viết
            </a>

            <!-- Bài viết -->
            <a href="{{ route('articles.index') }}"
                class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                       {{ $active === 'banner' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                </svg>
                Banner
            </a>

            <!-- Đơn hàng -->
            <a href="{{ route('orders.index') }}"
                class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                       {{ $active === 'order' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h6l2 4m-8-4v8H9m4-8V6c0-.26522-.1054-.51957-.2929-.70711C12.5196 5.10536 12.2652 5 12 5H4c-.26522 0-.51957.10536-.70711.29289C3.10536 5.48043 3 5.73478 3 6v9h2m14 0h2v-4m0 0h-5M8 8.66669V10l1.5 1.5m10 5c0 1.3807-1.1193 2.5-2.5 2.5s-2.5-1.1193-2.5-2.5S15.6193 14 17 14s2.5 1.1193 2.5 2.5Zm-10 0C9.5 17.8807 8.38071 19 7 19s-2.5-1.1193-2.5-2.5S5.61929 14 7 14s2.5 1.1193 2.5 2.5Z" />
                </svg>

                Đơn hàng
            </a>

            <!-- Khuyến mãi -->
            <a href="{{ route('discounts.index') }}"
                class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                       {{ $active === 'promo' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.5 12A2.5 2.5 0 0 1 21 9.5V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v2.5a2.5 2.5 0 0 1 0 5V17a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                </svg>


                Khuyến mãi
            </a>

            <!-- Khách hàng -->
            <a href="{{ route('users.index') }}"
                class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                       {{ $active === 'user' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                Khách hàng
            </a>

            <!-- Chat -->
            <a href="#"
                class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                       {{ $active === 'chat' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17h6l3 3v-3h2V9h-2M4 4h11v8H9l-3 3v-3H4V4Z" />
                </svg>

                Tin nhắn khách hàng
            </a>

            @can('role-list')
                <a href="{{ route('roles.index') }}"
                    class="flex items-center px-3 py-2 rounded text-sm transition-all duration-200 gap-2
                            {{ $active === 'role' ? 'bg-blue-100' : 'hover:bg-gray-200' }}">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2"
                            d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    Quyền hạng
                </a>
            @endcan
        </nav>
    </div>

    @auth
        <div class="flex items-center justify-between bg-gray-100 p-4 rounded-t-lg">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('logo.png') }}" class="w-8 h-8 rounded-full" alt="User Avatar">
                <span class="font-medium text-gray-900">{{ Auth::user()->name }}</span>
            </div>

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="text-red-500 hover:text-red-700 transition duration-200" title="Đăng xuất">
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
