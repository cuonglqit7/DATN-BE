@extends('layouts.main')
@section('title', 'Quản lý sản phẩm')
@section('content')
    <div class="max-w-7xl mx-auto bg-white p-4 rounded-lg shadow-md">
        <div class="flex items-center mb-4 justify-between">
            <h1 class="text-2xl font-bold">Quản lý sản phẩm</h1>
            <a href="{{ route('admin.products.add') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Thêm sản phẩm</a>
        </div>

        <form action="{{ route('admin.products.index') }}" method="GET" class="mb-4">
            <div class="flex flex-wrap gap-2 items-center justify-between">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm" class="border p-2 rounded w-60 text-sm"
                    value="{{ request('search') }}">
                <select name="sub_category_id" class="border p-2 rounded w-40 text-sm">
                    <option value="">Danh mục</option>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}"
                            {{ request('sub_category_id') == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->name }}
                        </option>
                    @endforeach
                </select>
                <select name="brand_id" class="border p-2 rounded w-40 text-sm">
                    <option value="">Thương hiệu</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="border p-2 rounded w-32 text-sm">
                    <option value="">Trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động
                    </option>
                </select>
                <input type="number" name="min_price" placeholder="Giá từ" class="border p-2 rounded w-24 text-sm"
                    value="{{ request('min_price') }}">
                <input type="number" name="max_price" placeholder="Giá đến" class="border p-2 rounded w-24 text-sm"
                    value="{{ request('max_price') }}">
                <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded text-sm hover:bg-blue-600">Tìm
                    kiếm</button>
            </div>
        </form>

        <table class="w-full border-collapse bg-white shadow-md rounded-md">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3">Mã SP</th>
                    <th class="p-3">Hình ảnh</th>
                    <th class="p-3">Tên sản phẩm</th>
                    <th class="p-3">Giá</th>
                    <th class="p-3">Tồn kho</th>
                    <th class="p-3">Đã bán</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-t">
                        <td class="p-3">{{ $product->product_code }}</td>
                        <td class="p-3"><img src="{{ $product->thumbnail_url ?? 'default.jpg' }}"
                                alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded"></td>
                        <td class="p-3">{{ $product->name }}</td>
                        <td class="p-3">{{ number_format($product->price) }} đ</td>
                        <td class="p-3">{{ $product->stock }}</td>
                        <td class="p-3">{{ $product->number_purchases }}</td>
                        <td class="p-3">{{ $product->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</td>
                        <td class="p-3 flex space-x-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Sửa</a>
                            <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
