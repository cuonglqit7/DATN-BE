@props(['active'])

<nav class="flex flex-col space-y-2">
    <a href="{{ route('home') }}"
        class="px-3 py-2 {{ $active === 'home' ? '' : 'hover:' }}bg-gray-700 rounded text-sm">Dashboard</a>
    <a href="{{ route('products.index') }}"
        class="px-3 py-2 {{ $active === 'product' ? '' : 'hover:' }}bg-gray-700 rounded text-sm">Sản
        phẩm</a>

    <a href="{{ route('users.index') }}"
        class="px-3 py-2 {{ $active === 'user' ? '' : 'hover:' }}bg-gray-700 rounded text-sm">Khách
        hàng</a>
    <a href="{{ route('roles.index') }}"
        class="px-3 py-2 {{ $active === 'role' ? '' : 'hover:' }}bg-gray-700 rounded text-sm">Quyền hạng</a>
    <a href="#" class="px-3 py-2 {{ $active === 'setting' ? '' : 'hover:' }}bg-gray-700 rounded text-sm">Cài
        đặt</a>
</nav>
